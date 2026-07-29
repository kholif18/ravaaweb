<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NavLinkController extends Controller
{
    public function index(Request $request)
    {
        $query = NavLink::with('children')->topLevel();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('label', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%");
            });
        }

        if ($position = $request->input('position')) {
            $query->where('position', $position);
        }

        $navLinks = $query->ordered()
            ->paginate($request->input('per_page', 15))
            ->withQueryString();

        if ($request->ajax()) {
            return view('admin.nav-links._table', compact('navLinks'))->render();
        }

        return view('admin.nav-links.index', [
            'navLinks' => $navLinks,
            'filters' => $request->only(['search', 'per_page', 'position']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label'      => 'required|string|max:255',
            'parent_id'  => 'nullable|integer|exists:nav_links,id',
            'url'        => 'required|string|max:500',
            'position'   => 'required|in:navbar,mobile,both',
            'target'     => 'required|in:_self,_blank',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if (!isset($validated['sort_order']) || $validated['sort_order'] === null) {
            $validated['sort_order'] = (NavLink::max('sort_order') ?? 0) + 1;
        }

        NavLink::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Link berhasil ditambahkan!']);
        }

        return redirect()->route('admin.nav-links.index')
            ->with('success', 'Link berhasil ditambahkan!');
    }

    public function edit(NavLink $navLink)
    {
        return response()->json([
            'success' => true,
            'navLink' => $navLink->toArray(),
        ]);
    }

    public function update(Request $request, NavLink $navLink)
    {
        $validated = $request->validate([
            'label'      => 'required|string|max:255',
            'parent_id'  => 'nullable|integer|exists:nav_links,id',
            'url'        => 'required|string|max:500',
            'position'   => 'required|in:navbar,mobile,both',
            'target'     => 'required|in:_self,_blank',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if (isset($validated['parent_id'])) {
            if ($validated['parent_id'] == $navLink->id) {
                return redirect()->back()->with('error', 'Tidak bisa menjadikan diri sendiri sebagai parent!');
            }
            $childIds = $navLink->children()->pluck('id')->toArray();
            if (in_array($validated['parent_id'], $childIds)) {
                return redirect()->back()->with('error', 'Tidak bisa menjadikan child sebagai parent!');
            }
        }

        $navLink->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Link berhasil diperbarui!']);
        }

        return redirect()->route('admin.nav-links.index')
            ->with('success', 'Link berhasil diperbarui!');
    }

    public function destroy(NavLink $navLink)
    {
        if ($navLink->isParent()) {
            $navLink->children()->update(['parent_id' => $navLink->parent_id]);
        }

        $navLink->delete();

        return redirect()->route('admin.nav-links.index')
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

        NavLink::whereIn('id', $ids)->delete();

        return redirect()->route('admin.nav-links.index')
            ->with('success', count($ids) . ' link berhasil dihapus!');
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'required|integer|exists:nav_links,id',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['ids'] as $index => $id) {
                NavLink::where('id', $id)->update(['sort_order' => $index]);
            }
        });

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Urutan link berhasil diperbarui!']);
        }

        return redirect()->back()->with('success', 'Urutan link berhasil diperbarui!');
    }

    public function updateStatus(Request $request, NavLink $navLink)
    {
        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $navLink->update($validated);

        return redirect()->back()
            ->with('success', 'Status link berhasil diperbarui!');
    }

    public function parents()
    {
        $parents = NavLink::topLevel()
            ->where('is_active', true)
            ->ordered()
            ->get()
            ->map(fn ($link) => ['id' => $link->id, 'label' => $link->label]);

        return response()->json($parents);
    }

    /**
     * Reset nav links to default state
     */
    public function reset()
    {
        $path = storage_path('app/nav-links-default.json');

        // If no default saved yet, save current state as default
        if (!file_exists($path)) {
            $this->saveDefaultState();
            return redirect()->back()
                ->with('success', 'Posisi default berhasil disimpan! Klik Reset lagi untuk mengembalikan ke posisi ini.');
        }

        $default = json_decode(file_get_contents($path), true);

        if (!is_array($default)) {
            return redirect()->back()
                ->with('error', 'File default corrupt!');
        }

        DB::transaction(function () use ($default) {
            // Delete all existing nav links
            NavLink::query()->delete();

            // Restore from default
            foreach ($default as $parentData) {
                $children = $parentData['children'] ?? [];
                unset($parentData['children']);

                $parent = NavLink::create($parentData);

                foreach ($children as $childData) {
                    $childData['parent_id'] = $parent->id;
                    NavLink::create($childData);
                }
            }
        });

        return redirect()->route('admin.nav-links.index')
            ->with('success', 'Navbar berhasil dikembalikan ke posisi default!');
    }

    /**
     * Save current state as default
     */
    private function saveDefaultState()
    {
        $links = NavLink::with('children')->topLevel()->ordered()->get();

        $default = $links->map(fn ($link) => [
            'label'      => $link->label,
            'url'        => $link->url,
            'position'   => $link->position,
            'target'     => $link->target,
            'sort_order' => $link->sort_order,
            'is_active'  => $link->is_active,
            'children'   => $link->children->map(fn ($child) => [
                'label'      => $child->label,
                'url'        => $child->url,
                'position'   => $child->position,
                'target'     => $child->target,
                'sort_order' => $child->sort_order,
                'is_active'  => $child->is_active,
            ])->toArray(),
        ])->toArray();

        $path = storage_path('app/nav-links-default.json');
        file_put_contents($path, json_encode($default, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
