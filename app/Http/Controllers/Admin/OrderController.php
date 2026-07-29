<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderSubmission;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = OrderSubmission::query();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($type = $request->input('type')) {
            $query->ofType($type);
        }

        if ($status = $request->input('status')) {
            $query->ofStatus($status);
        }

        $orders = $query->latest()
            ->paginate($request->input('per_page', 15))
            ->withQueryString();

        if ($request->ajax()) {
            return view('admin.orders._table', compact('orders'))->render();
        }

        return view('admin.orders.index', [
            'orders' => $orders,
            'filters' => $request->only(['search', 'type', 'status', 'per_page']),
            'typeLabels' => OrderSubmission::TYPE_LABELS,
            'statusLabels' => OrderSubmission::STATUS_LABELS,
        ]);
    }

    public function show(OrderSubmission $order)
    {
        if (\request()->ajax()) {
            return response()->json([
                'success' => true,
                'order' => $order->toArray(),
                'type_label' => $order->type_label,
                'status_label' => $order->status_label,
            ]);
        }

        return view('admin.orders.show', [
            'order' => $order,
            'typeLabels' => OrderSubmission::TYPE_LABELS,
            'statusLabels' => OrderSubmission::STATUS_LABELS,
        ]);
    }

    public function updateStatus(Request $request, OrderSubmission $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $order->update(['status' => $request->input('status')]);

        return redirect()->back()
            ->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function updateNotes(Request $request, OrderSubmission $order)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $order->update(['admin_notes' => $request->input('admin_notes')]);

        return redirect()->back()
            ->with('success', 'Catatan admin berhasil diperbarui!');
    }

    public function destroy(OrderSubmission $order)
    {
        // Delete files if exist
        if ($order->file_path && is_array($order->file_path)) {
            foreach ($order->file_path as $path) {
                if (\Storage::disk('public')->exists($path)) {
                    \Storage::disk('public')->delete($path);
                }
            }
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus!');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');
        if (is_string($ids)) {
            $ids = json_decode($ids, true);
        }

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Tidak ada pesanan yang dipilih.');
        }

        $orders = OrderSubmission::whereIn('id', $ids)->get();

        foreach ($orders as $order) {
            if ($order->file_path && is_array($order->file_path)) {
                foreach ($order->file_path as $path) {
                    if (\Storage::disk('public')->exists($path)) {
                        \Storage::disk('public')->delete($path);
                    }
                }
            }
            $order->delete();
        }

        return redirect()->route('admin.orders.index')
            ->with('success', count($ids) . ' pesanan berhasil dihapus!');
    }
}
