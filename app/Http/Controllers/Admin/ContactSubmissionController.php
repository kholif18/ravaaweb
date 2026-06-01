<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ContactSubmissionController extends Controller
{
    public function index()
    {
        $submissions = ContactSubmission::latest()->paginate(10);
        return view('admin.form-submissions.index', compact('submissions'));
    }

    public function show(ContactSubmission $contactSubmission)
    {
        if ($contactSubmission->status === 'unread') {
            $contactSubmission->update(['status' => 'read']);
        }
        return view('admin.form-submissions.show', compact('contactSubmission'));
    }

    public function update(Request $request, ContactSubmission $contactSubmission): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:unread,read,replied',
            'admin_notes' => 'nullable|string'
        ]);

        $contactSubmission->update($validated);
        return redirect()->back()->with('success', 'Status pengiriman berhasil diperbarui!');
    }

    public function destroy(ContactSubmission $contactSubmission): RedirectResponse
    {
        $contactSubmission->delete();
        return redirect()->route('admin.form-submissions.index')->with('success', 'Pengiriman berhasil dihapus!');
    }
}
