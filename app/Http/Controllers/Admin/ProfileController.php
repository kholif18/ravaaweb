<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    public function updateAvatar(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $file = $request->file('avatar');
        $fileName = $file->getClientOriginalName();
        $originalName = pathinfo($fileName, PATHINFO_FILENAME);
        $path = $file->store('avatars', 'public');

        $media = Media::create([
            'name'        => $originalName,
            'file_name'   => $fileName,
            'mime_type'   => $file->getMimeType(),
            'size'        => $file->getSize(),
            'path'        => $path,
            'disk'        => 'public',
            'uploaded_by' => $user->id,
        ]);

        // Delete old avatar media if exists
        if ($user->avatar_media_id) {
            $oldMedia = Media::find($user->avatar_media_id);
            if ($oldMedia) {
                $oldMedia->deleteFile();
                $oldMedia->delete();
            }
        }

        $user->avatar_media_id = $media->id;
        $user->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'url'     => $media->url,
            ]);
        }

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Avatar berhasil diperbarui!');
    }

    public function removeAvatar()
    {
        $user = Auth::guard('admin')->user();

        if ($user->avatar_media_id) {
            $media = Media::find($user->avatar_media_id);
            if ($media) {
                $media->deleteFile();
                $media->delete();
            }
            $user->avatar_media_id = null;
            $user->save();
        }

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Avatar berhasil dihapus!');
    }
}
