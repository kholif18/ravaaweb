<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactSubmission::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $submissions = $query->latest()
            ->paginate($request->input('per_page', 10))
            ->withQueryString();

        if ($request->ajax()) {
            return view('admin.contact-submissions._table', compact('submissions'))->render();
        }

        return view('admin.contact-submissions.index', [
            'submissions' => $submissions,
            'filters' => $request->only(['search', 'status', 'per_page']),
        ]);
    }

    public function show(ContactSubmission $contactSubmission)
    {
        if ($contactSubmission->status === 'unread') {
            $contactSubmission->update(['status' => 'read']);
        }

        return response()->json([
            'success' => true,
            'submission' => $contactSubmission->toArray(),
        ]);
    }

    public function destroy(ContactSubmission $contactSubmission)
    {
        $contactSubmission->delete();

        return redirect()->route('admin.contact-submissions.index')
            ->with('success', 'Pesan berhasil dihapus!');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');
        if (is_string($ids)) {
            $ids = json_decode($ids, true);
        }

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Tidak ada pesan yang dipilih.');
        }

        ContactSubmission::whereIn('id', $ids)->delete();

        return redirect()->route('admin.contact-submissions.index')
            ->with('success', count($ids) . ' pesan berhasil dihapus!');
    }

    public function markAsRead(ContactSubmission $contactSubmission)
    {
        $contactSubmission->update(['status' => 'read']);

        return redirect()->back()->with('success', 'Pesan ditandai sebagai sudah dibaca!');
    }

    public function markAsUnread(ContactSubmission $contactSubmission)
    {
        $contactSubmission->update(['status' => 'unread']);

        return redirect()->back()->with('success', 'Pesan ditandai sebagai belum dibaca!');
    }
}
