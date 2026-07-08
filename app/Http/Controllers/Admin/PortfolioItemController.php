<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PortfolioItemController extends Controller
{
    public function index(Request $request)
    {
        $query = PortfolioItem::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('client', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $portfolioItems = $query->orderBy('order')->orderBy('title')
            ->paginate($request->input('per_page', 15))
            ->withQueryString();

        if ($request->ajax()) {
            return view('admin.portfolio._table', compact('portfolioItems'))->render();
        }

        return view('admin.portfolio.index', [
            'portfolioItems' => $portfolioItems,
            'filters' => $request->only(['search', 'status', 'per_page']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'nullable|string|max:255|unique:portfolio_items,slug',
            'category'     => 'required|string|max:255',
            'client'       => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'image'        => 'nullable|string|max:500',
            'image_media_id' => 'nullable|exists:media,id',
            'tech'         => 'nullable|array',
            'tech.*'       => 'nullable|string|max:100',
            'project_url'  => 'nullable|string|max:500',
            'order'        => 'nullable|integer|min:0',
            'status'       => 'required|in:active,inactive',
            'is_featured'  => 'boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        // Auto-assign order if not explicitly provided
        if (!isset($validated['order']) || $validated['order'] === null) {
            $validated['order'] = (PortfolioItem::max('order') ?? 0) + 1;
        }

        PortfolioItem::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Portfolio berhasil ditambahkan!']);
        }

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio berhasil ditambahkan!');
    }

    public function edit(PortfolioItem $portfolioItem)
    {
        $data = $portfolioItem->toArray();
        if ($portfolioItem->imageMedia) {
            $data['media_url'] = $portfolioItem->imageMedia->url;
            $data['media_name'] = $portfolioItem->imageMedia->file_name;
        }

        return response()->json([
            'success' => true,
            'portfolioItem' => $data,
        ]);
    }

    public function update(Request $request, PortfolioItem $portfolioItem)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'nullable|string|max:255|unique:portfolio_items,slug,' . $portfolioItem->id,
            'category'     => 'required|string|max:255',
            'client'       => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'image'        => 'nullable|string|max:500',
            'image_media_id' => 'nullable|exists:media,id',
            'tech'         => 'nullable|array',
            'tech.*'       => 'nullable|string|max:100',
            'project_url'  => 'nullable|string|max:500',
            'order'        => 'nullable|integer|min:0',
            'status'       => 'required|in:active,inactive',
            'is_featured'  => 'boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        $portfolioItem->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Portfolio berhasil diperbarui!']);
        }

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio berhasil diperbarui!');
    }

    public function destroy(PortfolioItem $portfolioItem)
    {
        $portfolioItem->delete();

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio berhasil dihapus!');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');
        if (is_string($ids)) {
            $ids = json_decode($ids, true);
        }

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Tidak ada portfolio yang dipilih.');
        }

        PortfolioItem::whereIn('id', $ids)->delete();

        return redirect()->route('admin.portfolio.index')
            ->with('success', count($ids) . ' portfolio berhasil dihapus!');
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'required|integer|exists:portfolio_items,id',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['ids'] as $index => $id) {
                PortfolioItem::where('id', $id)->update(['order' => $index]);
            }
        });

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Urutan portfolio berhasil diperbarui!']);
        }

        return redirect()->back()->with('success', 'Urutan portfolio berhasil diperbarui!');
    }

    public function updateStatus(Request $request, PortfolioItem $portfolioItem)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $portfolioItem->update($validated);

        return redirect()->back()
            ->with('success', 'Status portfolio berhasil diperbarui!');
    }
}
