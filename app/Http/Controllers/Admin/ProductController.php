<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'mainMedia'])->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($category = $request->input('category')) {
            $query->where('category_id', $category);
        }

        if ($stockStatus = $request->input('stock_status')) {
            $query->where('stock_status', $stockStatus);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        $products = $query->paginate($request->input('per_page', 15))->withQueryString();
        $categories = Category::ordered()->get(['id', 'name']);

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::ordered()->with('children')->get(['id', 'name', 'parent_id']);
        $formattedCategories = $this->formatCategoriesWithHierarchy($categories);
        $relatedProducts = Product::where('status', 'published')->orderBy('name')->get(['id', 'name', 'sku']);
        
        return view('admin.products.create', compact('categories', 'formattedCategories', 'relatedProducts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);

        try {
            DB::beginTransaction();

            $validated['tags'] = $this->cleanArray($request->input('tags'));
            $validated['quick_infos'] = $this->cleanArray($request->input('quick_infos'));
            
            if ($request->boolean('has_variants')) {
                $validated['variant_attributes'] = $this->cleanArray($request->input('variant_attributes'));
            }

            if ($validated['status'] === 'published' && empty($validated['published_at'])) {
                $validated['published_at'] = now();
            }

            $product = Product::create($validated);

            $this->syncMedia($product, $request->input('gallery_images'));
            
            if ($request->has('related_products')) {
                $product->relatedProducts()->sync($request->input('related_products'));
            }

            if ($request->boolean('has_variants') && $request->has('variants')) {
                $this->handleProductVariants($product, $request->variants);
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Product creation failed: ' . $e->getMessage(), ['exception' => $e, 'request' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan produk: ' . $e->getMessage());
        }
    }

    public function show(Product $product)
    {
        $product->load(['category', 'mainMedia', 'galleryMedia', 'variants.media', 'relatedProducts']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::ordered()->get(['id', 'name', 'parent_id']);
        $formattedCategories = $this->formatCategoriesWithHierarchy($categories);
        $relatedProducts = Product::where('id', '!=', $product->id)->published()->orderBy('name')->get(['id', 'name', 'sku']);
        
        return view('admin.products.edit', compact('product', 'categories', 'formattedCategories', 'relatedProducts'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validateProduct($request, $product->id);

        try {
            DB::beginTransaction();

            $validated['tags'] = $this->cleanArray($request->input('tags'));
            $validated['quick_infos'] = $this->cleanArray($request->input('quick_infos'));
            
            if ($request->boolean('has_variants')) {
                $validated['variant_attributes'] = $this->cleanArray($request->input('variant_attributes'));
            } else {
                $validated['variant_attributes'] = null;
            }

            if ($validated['status'] === 'published' && empty($product->published_at)) {
                $validated['published_at'] = now();
            }

            $product->update($validated);

            $this->syncMedia($product, $request->input('gallery_images'));

            if ($request->has('related_products')) {
                $product->relatedProducts()->sync($request->input('related_products'));
            } else {
                $product->relatedProducts()->detach();
            }

            if ($request->boolean('has_variants')) {
                $this->handleProductVariants($product, $request->variants ?? [], $request->input('deleted_variants'));
            } else {
                $product->variants()->delete();
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Product update failed: ' . $e->getMessage(), ['exception' => $e, 'request' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product): RedirectResponse
    {
        try {
            $product->delete();
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
        } catch (\Throwable $e) {
            Log::error('Product deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus produk.');
        }
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = json_decode($request->input('ids'), true);
        
        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Tidak ada produk yang dipilih.');
        }

        try {
            DB::beginTransaction();
            Product::whereIn('id', $ids)->delete();
            DB::commit();
            return redirect()->route('admin.products.index')->with('success', count($ids) . ' produk berhasil dihapus!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Product bulk deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus beberapa produk.');
        }
    }

    public function updateStatus(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,published,archived',
        ]);

        $product->update($validated);
        return redirect()->back()->with('success', 'Status produk berhasil diperbarui!');
    }

    public function updateStock(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'stock_status' => 'required|in:in_stock,out_of_stock,pre_order',
        ]);

        $product->update($validated);
        return redirect()->back()->with('success', 'Status stok berhasil diperbarui!');
    }

    public function export()
    {
        $products = Product::with('category')->latest()->get();
        $filename = 'products-' . date('Y-m-d-His') . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($products) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'SKU', 'Category', 'Price', 'Stock Status', 'Status']);

            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->sku,
                    $product->category ? $product->category->name : '-',
                    $product->price,
                    $product->stock_status,
                    $product->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function validateProduct(Request $request, $productId = null): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:products,sku' . ($productId ? ',' . $productId : ''),
            'slug' => 'nullable|string|max:255|unique:products,slug' . ($productId ? ',' . $productId : ''),
            'description' => 'nullable|string',
            'specifications' => 'nullable|string', 
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required_unless:has_variants,true|nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_start_at' => 'nullable|date',
            'discount_end_at' => 'nullable|date|after_or_equal:discount_start_at',
            'stock_status' => 'required_unless:has_variants,true|nullable|in:in_stock,out_of_stock,pre_order',
            'weight' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'is_best_seller' => 'boolean',
            'is_new_arrival' => 'boolean',
            'is_digital' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'main_media_id' => 'nullable|exists:media,id',
            'gallery_images' => 'nullable|string', 
            'has_variants' => 'boolean',
            'variant_attributes' => 'nullable', 
            'quick_infos' => 'nullable', 
            'tags' => 'nullable', 
            'variants' => 'required_if:has_variants,true|array',
            'variants.*.id' => 'nullable|integer',
            'variants.*.name' => 'required_if:has_variants,true|string|max:255',
            'variants.*.sku' => 'nullable|string|max:100',
            'variants.*.price' => 'required_if:has_variants,true|numeric|min:0',
            'variants.*.discount_price' => 'nullable|numeric|min:0',
            'variants.*.discount_start_at' => 'nullable|date',
            'variants.*.discount_end_at' => 'nullable|date|after_or_equal:variants.*.discount_start_at',
            'variants.*.stock_status' => 'required_if:has_variants,true|in:in_stock,out_of_stock,pre_order',
            'variants.*.weight' => 'nullable|numeric|min:0',
            'variants.*.unit' => 'nullable|string|max:50',
            'variants.*.is_default' => 'boolean',
            'variants.*.attribute_options' => 'nullable|string', 
            'variants.*.image_id' => 'nullable|integer|exists:media,id',
            'deleted_variants' => 'nullable|string', 
        ];

        $validated = $request->validate($rules);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        return $validated;
    }

    private function handleProductVariants(Product $product, array $variants, $deletedVariantsJson = null): void {
        if ($deletedVariantsJson) {
            $deletedIds = json_decode($deletedVariantsJson, true);
            if (is_array($deletedIds)) {
                ProductVariant::where('product_id', $product->id)->whereIn('id', $deletedIds)->delete();
            }
        }

        foreach ($variants as $variantData) {
            $variantData['product_id'] = $product->id;
            
            if (isset($variantData['attribute_options']) && is_string($variantData['attribute_options'])) {
                $variantData['attribute_options'] = json_decode($variantData['attribute_options'], true);
            }
            
            $variantData['is_default'] = isset($variantData['is_default']) && $variantData['is_default'];
            
            if ($variantData['is_default']) {
                ProductVariant::where('product_id', $product->id)->update(['is_default' => false]);
            }
            
            if (isset($variantData['id']) && !empty($variantData['id'])) {
                $variant = ProductVariant::find($variantData['id']);
                if ($variant && $variant->product_id == $product->id) {
                    $id = $variantData['id'];
                    unset($variantData['id']);
                    $variant->update($variantData);
                }
            } else {
                unset($variantData['id']);
                ProductVariant::create($variantData);
            }
        }
    }

    private function syncMedia(Product $product, $galleryImagesJson) {
        if (empty($galleryImagesJson)) {
            $product->galleryMedia()->detach();
            return;
        }

        $galleryIds = json_decode($galleryImagesJson, true);
        if (is_array($galleryIds)) {
            $syncData = [];
            foreach ($galleryIds as $index => $mediaId) {
                $syncData[$mediaId] = ['type' => 'gallery', 'sort_order' => $index];
            }
            $product->galleryMedia()->sync($syncData);
        }
    }

    private function cleanArray($input): array {
        if (empty($input)) return [];
        if (is_array($input)) return array_values(array_filter($input));
        return array_values(array_filter(array_map('trim', explode(',', $input))));
    }

    private function formatCategoriesWithHierarchy($categories, $parentId = null, $level = 0) {
        $result = [];
        $prefix = str_repeat('— ', $level);
        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $result[$category->id] = $prefix . $category->name;
                $result = $result + $this->formatCategoriesWithHierarchy($categories, $category->id, $level + 1);
            }
        }
        return $result;
    }
}