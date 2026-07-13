<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeBuilderController extends Controller
{
    public function index()
    {
        $defaultContent = [
            'hero' => [
                'banner_ids' => [],
            ],
            'categories' => [
                'title' => 'Kategori Layanan',
                'subtitle' => 'Solusi lengkap untuk kebutuhan kreatif bisnis Anda',
                'category_ids' => [],
            ],
            'products' => [
                'title' => 'Produk Unggulan',
                'subtitle' => 'Temukan produk terbaik pilihan untuk kebutuhan Anda',
                'type' => 'featured', // featured, latest, selected
                'limit' => 8,
                'product_ids' => [],
            ],
            'rich_text' => [
                'title' => '',
                'content' => '',
                'is_visible' => false,
            ]
        ];

        $page = Page::getBySlug('home', $defaultContent);
        
        // Ensure all keys exist in nested structure
        $dbContent = $page->content ?? [];
        $content = array_replace_recursive($defaultContent, $dbContent);

        $banners = Banner::orderBy('order')->orderBy('id')->get();
        $categories = Category::where('status', 'active')->orderBy('order')->get();
        $products = Product::where('status', 'active')->latest()->get();

        return view('admin.home.index', compact('page', 'content', 'banners', 'categories', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hero.banner_ids' => 'nullable|array',
            'hero.banner_ids.*' => 'exists:banners,id',
            
            'categories.title' => 'nullable|string|max:255',
            'categories.subtitle' => 'nullable|string|max:500',
            'categories.category_ids' => 'nullable|array',
            'categories.category_ids.*' => 'exists:categories,id',
            
            'products.title' => 'nullable|string|max:255',
            'products.subtitle' => 'nullable|string|max:500',
            'products.type' => 'required|in:featured,latest,selected',
            'products.limit' => 'required|integer|min:1|max:50',
            'products.product_ids' => 'nullable|array',
            'products.product_ids.*' => 'exists:products,id',
            
            'rich_text.title' => 'nullable|string|max:255',
            'rich_text.content' => 'nullable|string',
            'rich_text.is_visible' => 'nullable',
        ]);

        // Fix boolean for rich_text is_visible
        $validated['rich_text']['is_visible'] = isset($validated['rich_text']['is_visible']) && ($validated['rich_text']['is_visible'] === '1' || $validated['rich_text']['is_visible'] === true || $validated['rich_text']['is_visible'] === 'on');

        // Set default empty arrays if not checked
        if (!isset($validated['hero']['banner_ids'])) {
            $validated['hero']['banner_ids'] = [];
        }
        if (!isset($validated['categories']['category_ids'])) {
            $validated['categories']['category_ids'] = [];
        }
        if (!isset($validated['products']['product_ids'])) {
            $validated['products']['product_ids'] = [];
        }

        $page = Page::getBySlug('home');
        $page->update([
            'content' => $validated
        ]);

        return redirect()->route('admin.home.index')
            ->with('success', 'Konfigurasi Home Builder berhasil diperbarui!');
    }
}
