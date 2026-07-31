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
     * Reads from stored path (after optimization) rather than UploadedFile.
     */
    private function createThumbnail($file, string $path): ?string
    {
        // Check mime from stored file (after potential PNG→WebP conversion)
        $fullPath = storage_path('app/public/' . $path);
        $mime = file_exists($fullPath) ? mime_content_type($fullPath) : $file->getMimeType();

        if (!str_starts_with($mime, 'image/') || $mime === 'image/gif' || $mime === 'image/svg+xml') {
            return null;
        }

        try {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($fullPath);
            $image->scale(width: 300);

            $thumbPath = dirname($path) . '/thumb_' . basename($path);
            $image->save(storage_path('app/public/' . $thumbPath));

            return $thumbPath;
        } catch (\Throwable $e) {
            report($e);
            return null;
        }
    }

    /**
     * Optimize image for web: resize + compress.
     * - JPEG: quality 85, overwrite in-place
     * - WebP: quality 80, overwrite in-place
     * - PNG: convert to WebP quality 85 (PNG encoder has no quality param)
     *
     * Returns [newPath, newMime] or null if unchanged.
     */
    private function optimizeImage(string $diskPath): ?array
    {
        $fullPath = storage_path('app/public/' . $diskPath);
        if (!file_exists($fullPath)) {
            \Log::warning('optimizeImage: file not found', ['path' => $fullPath]);
            return null;
        }

        $mime = mime_content_type($fullPath);
        \Log::info('optimizeImage: found', ['path' => $diskPath, 'mime' => $mime, 'size' => filesize($fullPath)]);

        if (!in_array($mime, ['image/jpeg', 'image/png', 'image/webp'])) {
            \Log::info('optimizeImage: skipped (not target mime)', ['mime' => $mime]);
            return null;
        }

        try {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($fullPath);
            $width = $image->width();
            \Log::info('optimizeImage: read ok', ['width' => $width]);

            if ($width > 1920) {
                $image->scale(width: 1920);
            }

            if ($mime === 'image/png') {
                // Try PNG → WebP first
                if (function_exists('imagewebp')) {
                    $newPath = preg_replace('/\.png$/i', '.webp', $diskPath);
                    $newFullPath = storage_path('app/public/' . $newPath);
                    $image->toWebp(quality: 85)->save($newFullPath);
                    \Log::info('optimizeImage: PNG→WebP done', ['newPath' => $newPath, 'newSize' => filesize($newFullPath)]);
                    return ['path' => $newPath, 'mime' => 'image/webp'];
                } else {
                    // Fallback: PNG → JPEG (quality 85)
                    $newPath = preg_replace('/\.png$/i', '.jpg', $diskPath);
                    $newFullPath = storage_path('app/public/' . $newPath);
                    $image->toJpeg(quality: 85)->save($newFullPath);
                    \Log::info('optimizeImage: PNG→JPG done (WebP not available)', ['newPath' => $newPath, 'newSize' => filesize($newFullPath)]);
                    return ['path' => $newPath, 'mime' => 'image/jpeg'];
                }
            } elseif ($mime === 'image/webp') {
                $image->toWebp(quality: 80)->save($fullPath);
            } else {
                $image->toJpeg(quality: 85)->save($fullPath);
            }

            \Log::info('optimizeImage: compressed', ['newSize' => filesize($fullPath)]);
        } catch (\Throwable $e) {
            \Log::error('optimizeImage: exception', ['error' => $e->getMessage()]);
        }

        return null;
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,webp,svg,pdf,doc,docx,xls,xlsx,mp4,mp3,zip|max:10240', // 10MB
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $originalName = pathinfo($fileName, PATHINFO_FILENAME);
        $path = $file->store('media', 'public');

        // Auto-optimize image for web (PNG → WebP, JPEG/WebP compress)
        $optimized = $this->optimizeImage($path);

        // If PNG was converted, delete original and use new path
        if ($optimized && $optimized['path'] !== $path) {
            $originalFullPath = storage_path('app/public/' . $path);
            if (file_exists($originalFullPath)) {
                unlink($originalFullPath);
            }
            $path = $optimized['path'];
            $fileName = pathinfo($fileName, PATHINFO_FILENAME) . '.' . pathinfo($path, PATHINFO_EXTENSION);
        }

        $thumbPath = $this->createThumbnail($file, $path);

        // Get actual file size (after optimization)
        $fullPath = storage_path('app/public/' . $path);
        $finalSize = file_exists($fullPath) ? filesize($fullPath) : $file->getSize();
        $finalMime = $optimized ? $optimized['mime'] : $file->getMimeType();

        $media = Media::create([
            'name' => $originalName,
            'file_name' => $fileName,
            'mime_type' => $finalMime,
            'size' => $finalSize,
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
        \Log::info('storeMultiple: called', ['files_count' => $request->file('files') ? count($request->file('files')) : 0]);

        $request->validate([
            'files' => 'required|array|max:20',
            'files.*' => 'file|mimes:jpg,jpeg,png,gif,webp,svg,pdf,doc,docx,xls,xlsx,mp4,mp3,zip|max:10240',
        ]);

        $uploaded = [];

        foreach ($request->file('files') as $file) {
            $fileName = $file->getClientOriginalName();
            $originalName = pathinfo($fileName, PATHINFO_FILENAME);
            $path = $file->store('media', 'public');

            \Log::info('storeMultiple: file stored', ['name' => $fileName, 'path' => $path]);

            // Auto-optimize image for web (PNG → WebP, JPEG/WebP compress)
            $optimized = $this->optimizeImage($path);

            // If PNG was converted, delete original and use new path
            if ($optimized && $optimized['path'] !== $path) {
                $originalFullPath = storage_path('app/public/' . $path);
                if (file_exists($originalFullPath)) {
                    unlink($originalFullPath);
                }
                $path = $optimized['path'];
                $fileName = pathinfo($fileName, PATHINFO_FILENAME) . '.' . pathinfo($path, PATHINFO_EXTENSION);
            }

            $thumbPath = $this->createThumbnail($file, $path);

            // Get actual file size (after optimization)
            $fullPath = storage_path('app/public/' . $path);
            $finalSize = file_exists($fullPath) ? filesize($fullPath) : $file->getSize();
            $finalMime = $optimized ? $optimized['mime'] : $file->getMimeType();

            $media = Media::create([
                'name' => $originalName,
                'file_name' => $fileName,
                'mime_type' => $finalMime,
                'size' => $finalSize,
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
