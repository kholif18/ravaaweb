<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FooterLinkController extends Controller
{
    public function index(Request $request)
    {
        $query = FooterLink::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('label', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%");
            });
        }

        $footerLinks = $query->ordered()
            ->paginate($request->input('per_page', 15))
            ->withQueryString();

        if ($request->ajax()) {
            return view('admin.footer-links._table', compact('footerLinks'))->render();
        }

        return view('admin.footer-links.index', [
            'footerLinks' => $footerLinks,
            'filters' => $request->only(['search', 'per_page']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label'     => 'required|string|max:255',
            'url'       => 'required|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if (!isset($validated['sort_order']) || $validated['sort_order'] === null) {
            $validated['sort_order'] = (FooterLink::max('sort_order') ?? 0) + 1;
        }

        FooterLink::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Link berhasil ditambahkan!']);
        }

        return redirect()->route('admin.footer-links.index')
            ->with('success', 'Link berhasil ditambahkan!');
    }

    public function edit(FooterLink $footerLink)
    {
        return response()->json([
            'success' => true,
            'footerLink' => $footerLink->toArray(),
        ]);
    }

    public function update(Request $request, FooterLink $footerLink)
    {
        $validated = $request->validate([
            'label'     => 'required|string|max:255',
            'url'       => 'required|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $footerLink->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Link berhasil diperbarui!']);
        }

        return redirect()->route('admin.footer-links.index')
            ->with('success', 'Link berhasil diperbarui!');
    }

    public function destroy(FooterLink $footerLink)
    {
        $footerLink->delete();

        return redirect()->route('admin.footer-links.index')
            ->with('success', 'Link berhasil dihapus!');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');
        if (is_string($ids)) {
            $ids = json_decode($ids, true);
        }

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Tidak ada link yang dipilih.');
        }

        FooterLink::whereIn('id', $ids)->delete();

        return redirect()->route('admin.footer-links.index')
            ->with('success', count($ids) . ' link berhasil dihapus!');
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'required|integer|exists:footer_links,id',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['ids'] as $index => $id) {
                FooterLink::where('id', $id)->update(['sort_order' => $index]);
            }
        });

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Urutan link berhasil diperbarui!']);
        }

        return redirect()->back()->with('success', 'Urutan link berhasil diperbarui!');
    }

    public function updateStatus(Request $request, FooterLink $footerLink)
    {
        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $footerLink->update($validated);

        return redirect()->back()
            ->with('success', 'Status link berhasil diperbarui!');
    }
}
