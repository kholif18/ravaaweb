<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $query = Banner::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%");
            });
        }

        $banners = $query->orderBy('order')->orderBy('id')
            ->paginate($request->input('per_page', 15))
            ->withQueryString();

        if ($request->ajax()) {
            return view('admin.banners._table', compact('banners'))->render();
        }

        return view('admin.banners.index', [
            'banners' => $banners,
            'filters' => $request->only(['search', 'per_page']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image'    => 'nullable|string|max:500',
            'image_media_id' => 'nullable|exists:media,id',
            'cta_text' => 'nullable|string|max:100',
            'cta_url'  => 'nullable|string|max:500',
            'badge'    => 'nullable|string|max:100',
            'order'    => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        // Auto-assign order if not explicitly provided
        if (!isset($validated['order']) || $validated['order'] === null) {
            $validated['order'] = (Banner::max('order') ?? 0) + 1;
        }

        Banner::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Banner berhasil ditambahkan!']);
        }

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil ditambahkan!');
    }

    public function edit(Banner $banner)
    {
        $data = $banner->toArray();
        if ($banner->imageMedia) {
            $data['media_url'] = $banner->imageMedia->url;
            $data['media_name'] = $banner->imageMedia->file_name;
        }

        return response()->json([
            'success' => true,
            'banner' => $data,
        ]);
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image'    => 'nullable|string|max:500',
            'image_media_id' => 'nullable|exists:media,id',
            'cta_text' => 'nullable|string|max:100',
            'cta_url'  => 'nullable|string|max:500',
            'badge'    => 'nullable|string|max:100',
            'order'    => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $banner->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Banner berhasil diperbarui!']);
        }

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil diperbarui!');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil dihapus!');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');
        if (is_string($ids)) {
            $ids = json_decode($ids, true);
        }

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Tidak ada banner yang dipilih.');
        }

        Banner::whereIn('id', $ids)->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', count($ids) . ' banner berhasil dihapus!');
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'required|integer|exists:banners,id',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['ids'] as $index => $id) {
                Banner::where('id', $id)->update(['order' => $index]);
            }
        });

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Urutan banner berhasil diperbarui!']);
        }

        return redirect()->back()->with('success', 'Urutan banner berhasil diperbarui!');
    }

    public function updateStatus(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $banner->update($validated);

        return redirect()->back()
            ->with('success', 'Status banner berhasil diperbarui!');
    }
}
