<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'thumbnail', 'media'])
            ->withCount('variants');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        $products = $query->latest()->paginate($request->input('per_page', 15));
        $products->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'price_discount' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'boolean',
            'sku' => 'nullable|string|max:50|unique:products,sku',
            'weight' => 'nullable|string|max:50',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',
            'media_ids' => 'nullable|array',
            'media_ids.*' => 'exists:media,id',
            'primary_media_id' => 'nullable|exists:media,id',
            'variants' => 'nullable|array',
            'variants.*.color' => 'nullable|string|max:50',
            'variants.*.size' => 'nullable|string|max:50',
            'variants.*.sku' => 'nullable|string|max:50',
            'variants.*.stock' => 'required_with:variants.*|integer|min:0',
            'variants.*.price_addition' => 'nullable|numeric|min:0',
            'variants.*.status' => 'required_with:variants.*|in:active,inactive',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $product = DB::transaction(function () use ($validated, $request) {
            $product = Product::create(collect($validated)->only([
                'name', 'slug', 'description', 'price', 'price_discount',
                'stock', 'category_id', 'status', 'is_featured', 'sku',
                'weight', 'meta_title', 'meta_description', 'meta_keywords',
            ])->toArray());

            // Attach tags
            if ($request->filled('tag_ids')) {
                $product->tags()->sync($request->input('tag_ids'));
            }

            // Attach media from library
            if ($request->filled('media_ids')) {
                foreach ($request->input('media_ids') as $index => $mediaId) {
                    $product->media()->attach($mediaId, [
                        'sort_order' => $index,
                        'is_primary' => $mediaId == $request->input('primary_media_id'),
                    ]);
                }

                // Set thumbnail to primary media
                if ($request->filled('primary_media_id')) {
                    $product->update(['thumbnail_id' => $request->input('primary_media_id')]);
                } else {
                    $firstMediaId = $request->input('media_ids')[0];
                    $product->update(['thumbnail_id' => $firstMediaId]);
                    $product->media()->updateExistingPivot($firstMediaId, ['is_primary' => true]);
                }
            }

            // Create variants
            if ($request->filled('variants')) {
                foreach ($request->input('variants') as $variantData) {
                    if (!empty($variantData['color']) || !empty($variantData['size'])) {
                        $product->variants()->create($variantData);
                    }
                }
            }

            return $product;
        });

        return redirect()->route('admin.products.index')
            ->with('success', "Product \"{$product->name}\" created successfully.");
    }

    public function edit(Product $product)
    {
        $product->load(['category', 'media', 'tags', 'variants']);
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'tags'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'price_discount' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'boolean',
            'sku' => 'nullable|string|max:50|unique:products,sku,' . $product->id,
            'weight' => 'nullable|string|max:50',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',
            'media_ids' => 'nullable|array',
            'media_ids.*' => 'exists:media,id',
            'primary_media_id' => 'nullable|exists:media,id',
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|integer',
            'variants.*.color' => 'nullable|string|max:50',
            'variants.*.size' => 'nullable|string|max:50',
            'variants.*.sku' => 'nullable|string|max:50',
            'variants.*.stock' => 'required_with:variants.*|integer|min:0',
            'variants.*.price_addition' => 'nullable|numeric|min:0',
            'variants.*.status' => 'required_with:variants.*|in:active,inactive',
            'delete_variant_ids' => 'nullable|array',
            'delete_variant_ids.*' => 'integer',
        ]);

        DB::transaction(function () use ($validated, $request, $product) {
            $product->update(collect($validated)->only([
                'name', 'description', 'price', 'price_discount',
                'stock', 'category_id', 'status', 'is_featured', 'sku',
                'weight', 'meta_title', 'meta_description', 'meta_keywords',
            ])->toArray());

            // Sync tags
            $product->tags()->sync($request->input('tag_ids', []));

            // Sync media from library
            $mediaIds = $request->input('media_ids', []);
            $primaryId = $request->input('primary_media_id');

            // Detach all current media, then reattach in order
            $product->media()->detach();
            foreach ($mediaIds as $index => $mediaId) {
                $product->media()->attach($mediaId, [
                    'sort_order' => $index,
                    'is_primary' => $mediaId == $primaryId,
                ]);
            }

            // Update thumbnail
            if (!empty($mediaIds)) {
                $thumbId = $primaryId ?? $mediaIds[0];
                $product->update(['thumbnail_id' => $thumbId]);
            } else {
                $product->update(['thumbnail_id' => null]);
            }

            // Handle variants
            if ($request->filled('delete_variant_ids')) {
                ProductVariant::whereIn('id', $request->input('delete_variant_ids'))
                    ->where('product_id', $product->id)
                    ->delete();
            }

            if ($request->filled('variants')) {
                foreach ($request->input('variants') as $variantData) {
                    if (!empty($variantData['color']) || !empty($variantData['size'])) {
                        if (!empty($variantData['id'])) {
                            $product->variants()->where('id', $variantData['id'])->update($variantData);
                        } else {
                            $product->variants()->create($variantData);
                        }
                    }
                }
            }
        });

        return redirect()->route('admin.products.index')
            ->with('success', "Product \"{$product->name}\" updated successfully.");
    }

    public function destroy(Product $product)
    {
        $name = $product->name;

        // Delete associated media files from disk
        foreach ($product->media as $media) {
            $media->deleteFile();
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', "Product \"{$name}\" deleted successfully.");
    }

    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
        ]);

        $count = 0;
        foreach ($request->input('ids') as $id) {
            $product = Product::findOrFail($id);
            foreach ($product->media as $media) {
                $media->deleteFile();
            }
            $product->delete();
            $count++;
        }

        return redirect()->route('admin.products.index')
            ->with('success', "{$count} products deleted.");
    }

    /**
     * Update product media ordering.
     */
    public function updateMediaOrder(Request $request, Product $product)
    {
        $request->validate([
            'media_order' => 'required|array',
            'media_order.*.id' => 'required|integer|exists:media,id',
            'media_order.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->input('media_order') as $item) {
            $product->media()->updateExistingPivot($item['id'], [
                'sort_order' => $item['sort_order'],
            ]);
        }

        return response()->json(['message' => 'Media order updated.']);
    }
}
