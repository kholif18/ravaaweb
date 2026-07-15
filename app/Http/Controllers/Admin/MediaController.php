<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::query()->with('uploader');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('file_name', 'like', "%{$search}%");
            });
        }

        if ($type = $request->input('type')) {
            match ($type) {
                'image' => $query->where('mime_type', 'like', 'image/%'),
                'video' => $query->where('mime_type', 'like', 'video/%'),
                'audio' => $query->where('mime_type', 'like', 'audio/%'),
                'document' => $query->whereNotIn('mime_type', [
                    'image/%', 'video/%', 'audio/%',
                ])->orWhereNull('mime_type'),
            };
        }

        $media = $query->latest()->paginate($request->input('per_page', 25));
        $media->withQueryString();

        if ($request->expectsJson()) {
            return response()->json([
                'data' => $media->items(),
                'pagination' => [
                    'total' => $media->total(),
                    'per_page' => $media->perPage(),
                    'current_page' => $media->currentPage(),
                    'last_page' => $media->lastPage(),
                ],
            ]);
        }

        return view('admin.media.index', compact('media'));
    }

    /**
     * Create an optimized thumbnail for image uploads.
     */
    private function createThumbnail($file, string $path): ?string
    {
        $mime = $file->getMimeType();
        if (!str_starts_with($mime, 'image/') || $mime === 'image/gif' || $mime === 'image/svg+xml') {
            return null;
        }

        try {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            $image->scale(width: 300);

            $thumbPath = dirname($path) . '/thumb_' . basename($path);
            $image->save(storage_path('app/public/' . $thumbPath));

            return $thumbPath;
        } catch (\Throwable $e) {
            report($e);
            return null;
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $originalName = pathinfo($fileName, PATHINFO_FILENAME);
        $path = $file->store('media', 'public');

        $thumbPath = $this->createThumbnail($file, $path);

        $media = Media::create([
            'name' => $originalName,
            'file_name' => $fileName,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'path' => $path,
            'thumb_path' => $thumbPath,
            'disk' => 'public',
            'uploaded_by' => Auth::id(),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['data' => $media], 201);
        }

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'files' => 'required|array|max:20',
            'files.*' => 'file|max:10240',
        ]);

        $uploaded = [];

        foreach ($request->file('files') as $file) {
            $fileName = $file->getClientOriginalName();
            $originalName = pathinfo($fileName, PATHINFO_FILENAME);
            $path = $file->store('media', 'public');

            $thumbPath = $this->createThumbnail($file, $path);

            $media = Media::create([
                'name' => $originalName,
                'file_name' => $fileName,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'path' => $path,
                'thumb_path' => $thumbPath,
                'disk' => 'public',
                'uploaded_by' => Auth::id(),
            ]);

            $uploaded[] = $media;
        }

        if ($request->expectsJson()) {
            return response()->json(['data' => $uploaded], 201);
        }

        return redirect()->back()->with('success', count($uploaded) . ' files uploaded.');
    }

    public function destroy(Media $media)
    {
        $media->deleteFile();
        $media->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Media deleted.']);
        }

        return redirect()->back()->with('success', 'File deleted.');
    }

    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:media,id',
        ]);

        $count = 0;
        foreach ($request->input('ids') as $id) {
            $media = Media::findOrFail($id);
            $media->deleteFile();
            $media->delete();
            $count++;
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => "{$count} files deleted."]);
        }

        return redirect()->back()->with('success', "{$count} files deleted.");
    }

    /**
     * API endpoint for the media picker modal.
     * Returns paginated media for selection.
     */
    public function picker(Request $request)
    {
        $query = Media::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('file_name', 'like', "%{$search}%");
            });
        }

        if ($type = $request->input('type')) {
            match ($type) {
                'image' => $query->where('mime_type', 'like', 'image/%'),
                'video' => $query->where('mime_type', 'like', 'video/%'),
                'audio' => $query->where('mime_type', 'like', 'audio/%'),
                'document' => $query->whereNotIn('mime_type', [
                    'image/%', 'video/%', 'audio/%',
                ])->orWhereNull('mime_type'),
            };
        }

        $media = $query->latest()->paginate($request->input('per_page', 25));

        return response()->json([
            'data' => $media->items(),
            'pagination' => [
                'total' => $media->total(),
                'per_page' => $media->perPage(),
                'current_page' => $media->currentPage(),
                'last_page' => $media->lastPage(),
            ],
        ]);
    }
}
