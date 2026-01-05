<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $categories = Category::active()
            ->ordered()
            ->get(['id', 'name', 'parent_id']);

        // Format categories for dropdown with hierarchy
        $formattedCategories = $this->formatCategoriesWithHierarchy($categories);

        return view('admin.products.create', [
            'categories' => $formattedCategories,
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
        $categories = Category::active()
            ->ordered()
            ->get(['id', 'name', 'parent_id']);

        // Format categories for dropdown with hierarchy
        $formattedCategories = $this->formatCategoriesWithHierarchy($categories);

        // Get related products (exclude current product)
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->published()
            ->get(['id', 'name', 'sku']);

        // Decode JSON fields if they are strings
        if (is_string($product->tags)) {
            $product->tags = json_decode($product->tags, true) ?: [];
        }
        if (is_string($product->colors)) {
            $product->colors = json_decode($product->colors, true) ?: [];
        }
        if (is_string($product->sizes)) {
            $product->sizes = json_decode($product->sizes, true) ?: [];
        }
        if (is_string($product->images)) {
            $product->images = json_decode($product->images, true) ?: [];
        }

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $formattedCategories,
            'relatedProducts' => $relatedProducts,
        ]);
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

            // Update stock status based on quantity
            if ($validated['manage_stock']) {
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

            // Handle related products
            if ($request->has('related_products')) {
                $product->relatedProducts()->sync($request->input('related_products'));
            } else {
                $product->relatedProducts()->detach();
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $productId,
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $productId,
            'barcode' => 'nullable|string|max:100|unique:products,barcode,' . $productId,
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'stock_status' => 'required|in:in_stock,out_of_stock,pre_order,backorder',
            'manage_stock' => 'boolean',
            'is_featured' => 'boolean',
            'is_best_seller' => 'boolean',
            'is_new_arrival' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'unit' => 'required|string|max:20',
            'tags' => 'nullable|string',
            'colors' => 'nullable|string',
            'sizes' => 'nullable|string',
            'main_image' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'specifications' => 'nullable|string',
            'features' => 'nullable|string',
            'usage_instructions' => 'nullable|string',
            'warranty_info' => 'nullable|string',
            'status' => 'required|in:published,draft,archived',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'related_products' => 'nullable|array',
            'related_products.*' => 'exists:products,id',
        ];

        return $request->validate($rules);
    }

    /**
     * Upload image and return filename.
     */
    private function uploadImage($image): string
    {
        $extension = $image->getClientOriginalExtension();
        $filename = 'product_' . time() . '_' . Str::random(10) . '.' . $extension;
        
        $image->storeAs('products', $filename, 'public');
        
        return $filename;
    }

    /**
     * Convert comma-separated string to array.
     */
    private function convertToArray(?string $data): ?string
    {
        if (empty($data)) {
            return null;
        }

        $items = array_map('trim', explode(',', $data));
        return json_encode(array_filter($items));
    }

    /**
     * Format categories with hierarchy.
     */
    private function formatCategoriesWithHierarchy($categories, $parentId = null, $level = 0)
    {
        $result = [];
        
        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $category->name = str_repeat('— ', $level) . $category->name;
                $result[] = $category;
                
                $children = $this->formatCategoriesWithHierarchy($categories, $category->id, $level + 1);
                $result = array_merge($result, $children);
            }
        }
        
        return $result;
    }
}