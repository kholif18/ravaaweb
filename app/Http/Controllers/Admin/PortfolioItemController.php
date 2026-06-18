<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PortfolioItemController extends Controller
{
    public function index()
    {
        $items = PortfolioItem::with('category')->orderBy('order')->paginate(15);
        $categories = PortfolioCategory::all();
        return view('admin.portfolio-items.index', compact('items', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:portfolio_categories,id',
            'client' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:4',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean'
        ]);

        PortfolioItem::create($validated);
        return redirect()->route('admin.portfolio-items.index')->with('success', 'Item Portfolio berhasil ditambahkan!');
    }

    public function update(Request $request, PortfolioItem $portfolioItem): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:portfolio_categories,id',
            'client' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:4',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean'
        ]);

        $portfolioItem->update($validated);
        return redirect()->route('admin.portfolio-items.index')->with('success', 'Item Portfolio berhasil diperbarui!');
    }

    public function destroy(PortfolioItem $portfolioItem): RedirectResponse
    {
        $portfolioItem->delete();
        return redirect()->route('admin.portfolio-items.index')->with('success', 'Item Portfolio berhasil dihapus!');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = json_decode($request->input('ids'), true);
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
        }

        PortfolioItem::whereIn('id', $ids)->delete();
        return redirect()->route('admin.portfolio-items.index')->with('success', count($ids) . ' item portfolio berhasil dihapus!');
    }
}
