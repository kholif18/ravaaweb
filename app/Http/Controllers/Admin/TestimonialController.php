<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $query = Testimonial::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $testimonials = $query->ordered()
            ->paginate($request->input('per_page', 10))
            ->withQueryString();

        if ($request->ajax()) {
            return view('admin.testimonials._table', compact('testimonials'))->render();
        }

        return view('admin.testimonials.index', [
            'testimonials' => $testimonials,
            'filters' => $request->only(['search', 'status', 'per_page']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name'    => 'required|string|max:255',
            'position'       => 'nullable|string|max:255',
            'company'        => 'nullable|string|max:255',
            'content'        => 'required|string',
            'rating'         => 'nullable|integer|min:1|max:5',
            'image_media_id' => 'nullable|exists:media,id',
            'status'         => 'required|in:active,inactive',
        ]);

        // Auto-assign order
        if (!isset($validated['order']) || $validated['order'] === null) {
            $validated['order'] = (Testimonial::max('order') ?? -1) + 1;
        }

        Testimonial::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Testimoni berhasil ditambahkan!']);
        }

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil ditambahkan!');
    }

    public function edit(Testimonial $testimonial)
    {
        $data = $testimonial->toArray();
        if ($testimonial->imageMedia) {
            $data['media_url'] = $testimonial->imageMedia->url;
            $data['media_name'] = $testimonial->imageMedia->file_name;
        }

        return response()->json([
            'success' => true,
            'testimonial' => $data,
        ]);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'client_name'    => 'required|string|max:255',
            'position'       => 'nullable|string|max:255',
            'company'        => 'nullable|string|max:255',
            'content'        => 'required|string',
            'rating'         => 'nullable|integer|min:1|max:5',
            'image_media_id' => 'nullable|exists:media,id',
            'status'         => 'required|in:active,inactive',
        ]);

        $testimonial->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Testimoni berhasil diperbarui!']);
        }

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil diperbarui!');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil dihapus!');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');
        if (is_string($ids)) {
            $ids = json_decode($ids, true);
        }

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Tidak ada testimoni yang dipilih.');
        }

        Testimonial::whereIn('id', $ids)->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', count($ids) . ' testimoni berhasil dihapus!');
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'required|integer|exists:testimonials,id',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['ids'] as $index => $id) {
                Testimonial::where('id', $id)->update(['order' => $index]);
            }
        });

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Urutan testimoni berhasil diperbarui!']);
        }

        return redirect()->back()->with('success', 'Urutan testimoni berhasil diperbarui!');
    }

    public function updateStatus(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $testimonial->update($validated);

        return redirect()->back()
            ->with('success', 'Status testimoni berhasil diperbarui!');
    }
}
