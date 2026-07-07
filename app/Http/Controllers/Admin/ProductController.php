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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'thumbnail', 'media', 'variants'])
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
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*.title' => 'required_with:features|string|max:255',
            'features.*.value' => 'required_with:features|string|max:255',
            'price' => 'required_without:variant_types|numeric|min:0',
            'price_discount' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'discount_start' => 'nullable|date',
            'discount_end' => 'nullable|date|after_or_equal:discount_start',
            'stock' => 'required_without:variant_types|integer|min:0',
            'is_service' => 'boolean',
            'variant_types' => 'nullable|array',
            'variant_types.*.name' => 'required_with:variant_types|string|max:100',
            'variant_types.*.values' => 'required_with:variant_types|array',
            'variant_types.*.values.*' => 'required_with:variant_types|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive,archived',
            'is_featured' => 'boolean',
            'sku' => 'nullable|string|max:50|unique:products,sku',
            'weight' => 'nullable|string|max:50',
            'length' => 'nullable|string|max:50',
            'width' => 'nullable|string|max:50',
            'height' => 'nullable|string|max:50',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',
            'media_ids' => 'nullable|array',
            'media_ids.*' => 'exists:media,id',
            'primary_media_id' => 'nullable|exists:media,id',
            'variants' => 'nullable|array',
            'variants.*.attributes' => 'nullable|array',
            'variants.*.sku' => 'nullable|string|max:50',
            'variants.*.price' => 'required_with:variants|numeric|min:0',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.price_discount' => 'nullable|numeric|min:0',
            'variants.*.discount_percent' => 'nullable|numeric|min:0|max:100',
            'variants.*.discount_start' => 'nullable|date',
            'variants.*.discount_end' => 'nullable|date',
            'variants.*.is_active' => 'boolean',
            'variants.*.is_service' => 'boolean',
            'variants.*.weight' => 'nullable|string|max:50',
            'variants.*.length' => 'nullable|string|max:50',
            'variants.*.width' => 'nullable|string|max:50',
            'variants.*.height' => 'nullable|string|max:50',
            'variant_images' => 'nullable|array',
            'variant_images.*' => 'nullable|integer|exists:media,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $product = DB::transaction(function () use ($validated, $request) {
            $product = Product::create(collect($validated)->only([
                'name', 'slug', 'short_description', 'description', 'features',
                'price', 'price_discount', 'discount_percent', 'discount_start', 'discount_end',
                'stock', 'is_service', 'variant_types',
                'category_id', 'status', 'is_featured', 'sku',
                'weight', 'length', 'width', 'height',
                'meta_title', 'meta_description', 'meta_keywords',
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
            }

            // Save primary media / thumbnail independently
            if ($request->filled('primary_media_id')) {
                $product->update(['thumbnail_id' => $request->input('primary_media_id')]);
                // Also ensure it's attached to gallery with is_primary flag
                if (!$request->filled('media_ids') || !in_array($request->input('primary_media_id'), $request->input('media_ids', []))) {
                    $maxOrder = $product->media()->max('product_media.sort_order') ?? -1;
                    $product->media()->attach($request->input('primary_media_id'), [
                        'sort_order' => $maxOrder + 1,
                        'is_primary' => true,
                    ]);
                }
            } elseif ($request->filled('media_ids')) {
                // No primary selected but gallery exists → set first as primary
                $firstMediaId = $request->input('media_ids')[0];
                $product->update(['thumbnail_id' => $firstMediaId]);
                $product->media()->updateExistingPivot($firstMediaId, ['is_primary' => true]);
            }

            // Create variants
            if ($request->filled('variants')) {
                $variantImages = $request->input('variant_images', []);

                foreach ($request->input('variants') as $index => $variantData) {
                    $variantData['product_id'] = $product->id;

                    // If a media ID was picked for this variant, store it
                    if (!empty($variantImages[$index])) {
                        $variantData['image'] = $variantImages[$index];
                    }

                    $product->variants()->create(collect($variantData)->only([
                        'attributes', 'sku', 'price', 'stock', 'price_discount',
                        'discount_percent', 'discount_start', 'discount_end',
                        'is_active', 'is_service', 'weight', 'length', 'width', 'height',
                        'image',
                    ])->toArray());
                }
            }

            return $product;
        });

        return redirect()->route('admin.products.index')
            ->with('success', "Product \"{$product->name}\" created successfully.");
    }

    public function edit(Product $product)
    {
        $product->load(['category', 'media', 'tags', 'variants.media', 'thumbnail']);
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'tags'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*.title' => 'required_with:features|string|max:255',
            'features.*.value' => 'required_with:features|string|max:255',
            'price' => 'required_without:variant_types|numeric|min:0',
            'price_discount' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'discount_start' => 'nullable|date',
            'discount_end' => 'nullable|date|after_or_equal:discount_start',
            'stock' => 'required_without:variant_types|integer|min:0',
            'is_service' => 'boolean',
            'variant_types' => 'nullable|array',
            'variant_types.*.name' => 'required_with:variant_types|string|max:100',
            'variant_types.*.values' => 'required_with:variant_types|array',
            'variant_types.*.values.*' => 'required_with:variant_types|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive,archived',
            'is_featured' => 'boolean',
            'sku' => 'nullable|string|max:50|unique:products,sku,' . $product->id,
            'weight' => 'nullable|string|max:50',
            'length' => 'nullable|string|max:50',
            'width' => 'nullable|string|max:50',
            'height' => 'nullable|string|max:50',
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
            'variants.*.attributes' => 'nullable|array',
            'variants.*.sku' => 'nullable|string|max:50',
            'variants.*.price' => 'required_with:variants|numeric|min:0',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.price_discount' => 'nullable|numeric|min:0',
            'variants.*.discount_percent' => 'nullable|numeric|min:0|max:100',
            'variants.*.discount_start' => 'nullable|date',
            'variants.*.discount_end' => 'nullable|date',
            'variants.*.is_active' => 'boolean',
            'variants.*.is_service' => 'boolean',
            'variants.*.weight' => 'nullable|string|max:50',
            'variants.*.length' => 'nullable|string|max:50',
            'variants.*.width' => 'nullable|string|max:50',
            'variants.*.height' => 'nullable|string|max:50',
            'delete_variant_ids' => 'nullable|array',
            'delete_variant_ids.*' => 'integer',
        ]);

        DB::transaction(function () use ($validated, $request, $product) {
            $product->update(collect($validated)->only([
                'name', 'short_description', 'description', 'features',
                'price', 'price_discount', 'discount_percent', 'discount_start', 'discount_end',
                'stock', 'is_service', 'variant_types',
                'category_id', 'status', 'is_featured', 'sku',
                'weight', 'length', 'width', 'height',
                'meta_title', 'meta_description', 'meta_keywords',
            ])->toArray());

            // Sync tags
            $product->tags()->sync($request->input('tag_ids', []));

            // Sync media from library
            $mediaIds = $request->input('media_ids') ?? [];
            $primaryId = $request->input('primary_media_id');

            // Ensure primary_id is in the gallery list
            if (!empty($primaryId) && !in_array($primaryId, $mediaIds)) {
                $mediaIds[] = $primaryId;
            }

            $product->media()->detach();
            foreach ($mediaIds as $index => $mediaId) {
                $product->media()->attach($mediaId, [
                    'sort_order' => $index,
                    'is_primary' => $mediaId == $primaryId,
                ]);
            }

            if (!empty($primaryId)) {
                $product->update(['thumbnail_id' => $primaryId]);
            } elseif (!empty($mediaIds)) {
                $product->update(['thumbnail_id' => $mediaIds[0]]);
            } else {
                $product->update(['thumbnail_id' => null]);
            }

            // Handle variant deletion
            if ($request->filled('delete_variant_ids')) {
                $deleteIds = $request->input('delete_variant_ids');
                // Delete variant images from storage
                $variantsToDelete = ProductVariant::whereIn('id', $deleteIds)
                    ->where('product_id', $product->id)
                    ->get();
                foreach ($variantsToDelete as $v) {
                    if ($v->image) {
                        Storage::disk('public')->delete($v->image);
                    }
                }
                ProductVariant::whereIn('id', $deleteIds)
                    ->where('product_id', $product->id)
                    ->delete();
            }

            // Handle variants
            if ($request->filled('variants')) {
                $variantImages = $request->input('variant_images', []);

                foreach ($request->input('variants') as $index => $variantData) {
                    $variantAttributes = collect($variantData)->only([
                        'attributes', 'sku', 'price', 'stock', 'price_discount',
                        'discount_percent', 'discount_start', 'discount_end',
                        'is_active', 'is_service', 'weight', 'length', 'width', 'height',
                    ])->toArray();

                    // If a media ID was picked for this variant, store it
                    if (!empty($variantImages[$index])) {
                        $variantAttributes['image'] = $variantImages[$index];
                    }

                    if (!empty($variantData['id'])) {
                        $product->variants()->where('id', $variantData['id'])->update($variantAttributes);
                    } else {
                        $variantAttributes['product_id'] = $product->id;
                        $product->variants()->create($variantAttributes);
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

        // Delete variant media files from disk
        foreach ($product->variants as $variant) {
            if ($variant->media) {
                $variant->media->deleteFile();
            }
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
            foreach ($product->variants as $variant) {
                if ($variant->media) {
                    $variant->media->deleteFile();
                }
            }
            $product->delete();
            $count++;
        }

        return redirect()->route('admin.products.index')
            ->with('success', "{$count} products deleted.");
    }

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
