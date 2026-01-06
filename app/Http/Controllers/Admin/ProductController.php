<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category')->latest();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Filter by category
        if ($category = $request->input('category')) {
            $query->where('category_id', $category);
        }

        // Filter by stock status
        if ($stock_status = $request->input('stock_status')) {
            $query->where('stock_status', $stock_status);
        }

        // Filter by featured
        if ($request->has('featured')) {
            $query->where('is_featured', $request->boolean('featured'));
        }

        // Filter by price range
        if ($min_price = $request->input('min_price')) {
            $query->where('price', '>=', $min_price);
        }
        if ($max_price = $request->input('max_price')) {
            $query->where('price', '<=', $max_price);
        }

        // Paginate
        $products = $query->paginate($request->input('per_page', 15))
            ->withQueryString();

        // Get categories for filter
        $categories = Category::active()
            ->ordered()
            ->get(['id', 'name']);

        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $request->only([
                'search', 'status', 'category', 'stock_status', 
                'featured', 'min_price', 'max_price', 'per_page'
            ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get categories with hierarchy
        $categories = Category::active()
            ->ordered()
            ->with('children') // Eager load children jika perlu
            ->get(['id', 'name', 'parent_id']);
        
        // Format categories for dropdown with hierarchy
        $formattedCategories = $this->formatCategoriesWithHierarchy($categories);
        
        // Get related products (published only, exclude if needed)
        $relatedProducts = Product::where('status', 'published')
            ->orderBy('name')
            ->get(['id', 'name', 'sku']);
        
        return view('admin.products.create', [
            'categories' => $categories, // Kirim original categories object
            'formattedCategories' => $formattedCategories, // Kirim juga formatted untuk select
            'relatedProducts' => $relatedProducts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);

        try {
            DB::beginTransaction();

            // Handle image upload
            if ($request->hasFile('main_image')) {
                $validated['main_image'] = $this->uploadImage($request->file('main_image'));
            }

            // Handle multiple images
            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $this->uploadImage($image);
                }
                $validated['images'] = json_encode($imagePaths);
            }

            // Convert arrays to JSON
            $validated['tags'] = $this->convertToArray($request->input('tags'));
            $validated['colors'] = $this->convertToArray($request->input('colors'));
            $validated['sizes'] = $this->convertToArray($request->input('sizes'));
            
            // Handle variant attributes
            if ($request->has('variant_attributes') && $request->boolean('has_variants')) {
                $validated['variant_attributes'] = $this->convertToArray($request->input('variant_attributes'));
            }

            // Set published_at if status is published
            if ($validated['status'] === 'published' && empty($validated['published_at'])) {
                $validated['published_at'] = now();
            }

            // Create product
            $product = Product::create($validated);

            // Handle related products if any
            if ($request->has('related_products')) {
                $product->relatedProducts()->sync($request->input('related_products'));
            }

            // Handle product variants if any
            if ($request->boolean('has_variants') && $request->has('variants')) {
                $this->handleProductVariants($product, $request->variants, $request->file('variant_images', []));
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', [
            'product' => $product->load('category', 'reviews'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // Get categories with hierarchy
        $categories = Category::active()
            ->ordered()
            ->get(['id', 'name', 'parent_id']);
        
        // Format categories for dropdown with hierarchy
        $formattedCategories = $this->formatCategoriesWithHierarchy($categories);
        
        // Get related products (exclude current product)
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->published()
            ->orderBy('name')
            ->get(['id', 'name', 'sku']);
        
        // Decode JSON fields for the view
        $this->decodeProductJsonFields($product);
        
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories, // Kirim original collection untuk flexibility
            'formattedCategories' => $formattedCategories, // Kirim formatted untuk dropdown
            'relatedProducts' => $relatedProducts,
        ]);
    }

    /**
     * Decode product JSON fields for the view
     */
    private function decodeProductJsonFields(Product $product): void
    {
        $fieldsToDecode = ['tags', 'colors', 'sizes', 'images', 'variant_attributes'];
        
        foreach ($fieldsToDecode as $field) {
            $value = $product->$field;
            
            if (is_string($value)) {
                $decoded = json_decode($value, true);
                $product->setAttribute($field, is_array($decoded) ? $decoded : []);
            } elseif (is_null($value)) {
                $product->setAttribute($field, []);
            }
            // Jika sudah array, biarkan saja
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validateProduct($request, $product->id);

        try {
            DB::beginTransaction();

            // Handle main image update
            if ($request->hasFile('main_image')) {
                // Delete old image if exists
                if ($product->main_image) {
                    Storage::delete('products/' . $product->main_image);
                }
                $validated['main_image'] = $this->uploadImage($request->file('main_image'));
            } elseif ($request->has('remove_main_image')) {
                if ($product->main_image) {
                    Storage::delete('products/' . $product->main_image);
                }
                $validated['main_image'] = null;
            }

            // Handle additional images
            if ($request->hasFile('images')) {
                $existingImages = $product->images ? json_decode($product->images, true) : [];
                $newImages = [];
                
                foreach ($request->file('images') as $image) {
                    $newImages[] = $this->uploadImage($image);
                }
                
                $validated['images'] = json_encode(array_merge($existingImages, $newImages));
            }

            // Handle image removal
            if ($request->has('remove_images')) {
                $imagesToRemove = $request->input('remove_images');
                $existingImages = $product->images ? json_decode($product->images, true) : [];
                
                // Delete files from storage
                foreach ($imagesToRemove as $image) {
                    if (in_array($image, $existingImages)) {
                        Storage::delete('products/' . $image);
                    }
                }
                
                // Remove from array
                $existingImages = array_diff($existingImages, $imagesToRemove);
                $validated['images'] = json_encode(array_values($existingImages));
            }

            // Convert arrays to JSON
            $validated['tags'] = $this->convertToArray($request->input('tags'));
            $validated['colors'] = $this->convertToArray($request->input('colors'));
            $validated['sizes'] = $this->convertToArray($request->input('sizes'));
            
            // Handle variant attributes
            if ($request->boolean('has_variants') && $request->has('variant_attributes')) {
                $validated['variant_attributes'] = $this->convertToArray($request->input('variant_attributes'));
            } else {
                $validated['variant_attributes'] = null;
            }

            // Update stock status based on quantity (only for non-variant products)
            if ($validated['manage_stock'] && !$request->boolean('has_variants')) {
                if ($validated['stock_quantity'] <= 0) {
                    $validated['stock_status'] = 'out_of_stock';
                } elseif ($validated['stock_quantity'] <= $validated['minimum_stock']) {
                    $validated['stock_status'] = 'in_stock';
                }
            }

            // Set published_at if status changed to published
            if ($validated['status'] === 'published' && $product->status !== 'published') {
                $validated['published_at'] = now();
            }

            // Update product
            $product->update($validated);

            // Handle related products with order
            if ($request->has('related_products')) {
                $relatedProducts = [];
                $order = 1;
                foreach ($request->input('related_products') as $relatedId) {
                    $relatedProducts[$relatedId] = ['order' => $order++];
                }
                $product->relatedProducts()->sync($relatedProducts);
            } else {
                $product->relatedProducts()->detach();
            }

            // Handle product variants
            if ($request->boolean('has_variants')) {
                $this->handleProductVariants(
                    $product, 
                    $request->variants ?? [], 
                    $request->file('variant_images', []), 
                    $request->input('deleted_variants', [])
                );
                
                // Update overall stock quantity for variant products
                $totalStock = $product->variants()->sum('stock_quantity');
                $product->update(['stock_quantity' => $totalStock]);
            } else {
                // Jika produk diubah menjadi non-varian, hapus semua varian
                $product->variants()->delete();
            }

            DB::commit();

            return redirect()->route('admin.products.edit', $product)
                ->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Handle product variants creation and update
     */
    private function handleProductVariants(
        Product $product, 
        array $variants, 
        array $variantImages = [], 
        array $deletedVariantIds = []
    ): void {
        // Delete removed variants
        if (!empty($deletedVariantIds)) {
            $variantsToDelete = ProductVariant::where('product_id', $product->id)
                ->whereIn('id', $deletedVariantIds)
                ->get();
            
            foreach ($variantsToDelete as $variant) {
                // Delete variant image if exists
                if ($variant->image) {
                    Storage::delete('variants/' . $variant->image);
                }
                $variant->delete();
            }
        }

        // Process each variant
        foreach ($variants as $index => $variantData) {
            // Prepare variant data
            $variantData['product_id'] = $product->id;
            
            // Handle attribute options
            if (isset($variantData['attribute_options']) && is_string($variantData['attribute_options'])) {
                $variantData['attribute_options'] = json_decode($variantData['attribute_options'], true);
            }
            
            // Convert boolean values
            $variantData['is_default'] = $variantData['is_default'] ?? false;
            
            // Ensure only one variant is marked as default
            if ($variantData['is_default']) {
                ProductVariant::where('product_id', $product->id)
                    ->where('id', '!=', $variantData['id'] ?? null)
                    ->update(['is_default' => false]);
            }
            
            // Handle variant image upload
            if (isset($variantImages[$index])) {
                // Delete old image if exists and we're updating
                if (isset($variantData['id'])) {
                    $existingVariant = ProductVariant::find($variantData['id']);
                    if ($existingVariant && $existingVariant->image) {
                        Storage::delete('variants/' . $existingVariant->image);
                    }
                }
                
                $variantData['image'] = $this->uploadVariantImage($variantImages[$index]);
            }
            
            // Create or update variant
            if (isset($variantData['id'])) {
                // Update existing variant
                $variant = ProductVariant::find($variantData['id']);
                if ($variant && $variant->product_id == $product->id) {
                    unset($variantData['id']);
                    $variant->update($variantData);
                }
            } else {
                // Create new variant
                unset($variantData['id']);
                ProductVariant::create($variantData);
            }
        }
    }

    /**
     * Upload variant image
     */
    private function uploadVariantImage($image): string
    {
        $path = 'variants';
        $filename = 'variant_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        
        // Store image
        $image->storeAs($path, $filename, 'public');
        
        return $filename;
    }

    private function deleteImage($imagePath)
    {
        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Delete images
            if ($product->main_image) {
                Storage::delete('products/' . $product->main_image);
            }

            if ($product->images) {
                $images = json_decode($product->images, true);
                foreach ($images as $image) {
                    Storage::delete('products/' . $image);
                }
            }

            // Delete product
            $product->delete();

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete products.
     */
    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
        ]);

        try {
            DB::beginTransaction();

            $products = Product::whereIn('id', $validated['ids'])->get();

            foreach ($products as $product) {
                // Delete images
                if ($product->main_image) {
                    Storage::delete('products/' . $product->main_image);
                }

                if ($product->images) {
                    $images = json_decode($product->images, true);
                    foreach ($images as $image) {
                        Storage::delete('products/' . $image);
                    }
                }

                $product->delete();
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', count($validated['ids']) . ' produk berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update product status.
     */
    public function updateStatus(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:published,draft,archived',
        ]);

        if ($validated['status'] === 'published' && !$product->published_at) {
            $validated['published_at'] = now();
        }

        $product->update($validated);

        return redirect()->back()
            ->with('success', 'Status produk berhasil diperbarui!');
    }

    /**
     * Update stock quantity.
     */
    public function updateStock(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'stock_quantity' => 'required|integer|min:0',
            'stock_status' => 'required|in:in_stock,out_of_stock,pre_order,backorder',
            'reason' => 'nullable|string|max:255',
        ]);

        $oldQuantity = $product->stock_quantity;
        
        $product->update([
            'stock_quantity' => $validated['stock_quantity'],
            'stock_status' => $validated['stock_status'],
        ]);

        // Log stock adjustment
        if ($oldQuantity != $validated['stock_quantity']) {
            // You can create a StockHistory model to track changes
            // StockHistory::create([...]);
        }

        return redirect()->back()
            ->with('success', 'Stok produk berhasil diperbarui!');
    }

    /**
     * Export products.
     */
    public function export(Request $request)
    {
        $products = Product::with('category')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="products_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fwrite($file, "\xEF\xBB\xBF");
            
            // Headers
            fputcsv($file, [
                'ID', 'SKU', 'Nama', 'Kategori', 'Harga', 'Harga Diskon',
                'Stok', 'Status Stok', 'Status', 'Terjual', 'Dilihat',
                'Rating', 'Tanggal Dibuat'
            ]);

            // Data
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->sku,
                    $product->name,
                    $product->category?->name,
                    $product->price,
                    $product->discount_price,
                    $product->stock_quantity,
                    $product->stock_status,
                    $product->status,
                    $product->sold_count,
                    $product->view_count,
                    $product->rating_average,
                    $product->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Validate product data.
     */
    private function validateProduct(Request $request, $productId = null): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:products,sku' . ($productId ? ',' . $productId : ''),
            'barcode' => 'nullable|string|max:100|unique:products,barcode' . ($productId ? ',' . $productId : ''),
            'slug' => 'nullable|string|max:255|unique:products,slug' . ($productId ? ',' . $productId : ''),
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'stock_status' => 'required|in:in_stock,out_of_stock,pre_order,backorder',
            'manage_stock' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_best_seller' => 'boolean',
            'is_new_arrival' => 'boolean',
            'specifications' => 'nullable|string',
            'features' => 'nullable|string',
            'usage_instructions' => 'nullable|string',
            'warranty_info' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'main_image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
            'has_variants' => 'boolean',
            'variant_attributes' => 'nullable|array',
            'variant_attributes.*' => 'string|max:50',
            'variants' => 'required_if:has_variants,true|array',
            'variants.*.name' => 'required_if:has_variants,true|string|max:255',
            'variants.*.sku' => 'nullable|string|max:100',
            'variants.*.price' => 'required_if:has_variants,true|numeric|min:0',
            'variants.*.discount_price' => 'nullable|numeric|min:0',
            'variants.*.discount_start' => 'nullable|date',
            'variants.*.discount_end' => 'nullable|date|after_or_equal:variants.*.discount_start',
            'variants.*.stock_quantity' => 'required_if:has_variants,true|integer|min:0',
            'variants.*.weight' => 'nullable|numeric|min:0',
            'variants.*.is_default' => 'boolean',
            'variant_images.*' => 'nullable|image|max:2048',
            'deleted_variants' => 'nullable|array',
            'deleted_variants.*' => 'integer|exists:product_variants,id',
        ];

        // Add related products validation
        if ($request->has('related_products')) {
            $rules['related_products'] = 'array';
            $rules['related_products.*'] = 'exists:products,id';
        }

        $validated = $request->validate($rules);

        // Auto-generate SKU if empty
        if (empty($validated['sku']) && !$request->boolean('has_variants')) {
            $validated['sku'] = 'SKU-' . strtoupper(uniqid());
        }

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Set default values for non-variant products
        if (!$request->boolean('has_variants')) {
            $validated['has_variants'] = false;
            $validated['variant_attributes'] = null;
        }

        return $validated;
    }

    /**
     * Upload image and return filename.
     */
    private function uploadImage($image): string
    {
        $path = 'products';
        $filename = 'product_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        
        // Store image
        $image->storeAs($path, $filename, 'public');
        
        return $filename;
    }

    /**
     * Convert comma-separated string to array.
     */
    private function convertToArray($input): ?string
    {
        if (empty($input)) {
            return null;
        }

        if (is_array($input)) {
            return json_encode(array_filter($input));
        }

        $items = explode(',', $input);
        $items = array_map('trim', $items);
        $items = array_filter($items);

        return !empty($items) ? json_encode($items) : null;
    }

    /**
     * Format categories with hierarchy.
     */
    private function formatCategoriesWithHierarchy($categories, $parentId = null, $level = 0)
    {
        $result = [];
        $prefix = str_repeat('— ', $level);
        
        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $result[$category->id] = $prefix . $category->name;
                
                // Get children recursively
                $children = $this->formatCategoriesWithHierarchy($categories, $category->id, $level + 1);
                $result = $result + $children;
            }
        }
        
        return $result;
    }
}