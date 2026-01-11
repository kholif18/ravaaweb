<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MediaController extends Controller
{
    private ImageManager $image;

    public function __construct()
    {
        $this->image = new ImageManager(new Driver());
    }

    /* =========================
       INDEX (LIST MEDIA)
    ========================= */
    public function index(Request $request)
    {
        $query = Media::query()->latest();

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->extension && $request->extension !== 'all') {
            $query->where('extension', $request->extension);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->sort === 'largest') {
            $query->orderBy('size', 'desc');
        } elseif ($request->sort === 'smallest') {
            $query->orderBy('size', 'asc');
        }

        $media = $query->paginate(20);

        $media->each(function ($m) {
            $m->url = Storage::url("media/{$m->filename}");
            $m->thumbnail_url = $m->thumbnail_path
                ? Storage::url($m->thumbnail_path)
                : $m->url;

            $m->formatted_size = $this->formatBytes($m->size);
        });

        return view('admin.media.index', compact('media'));
    }

    /* =========================
       STORE (UPLOAD)
    ========================= */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files'   => ['required','array'],
            'files.*' => ['required','image','mimes:jpg,jpeg,png,webp,gif,svg','max:5120'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $saved = [];

        foreach ($request->file('files') as $file) {
            try {
                $originalName = $file->getClientOriginalName();           // foto.jpg
                $name         = pathinfo($originalName, PATHINFO_FILENAME); // foto
                $ext          = strtolower($file->getClientOriginalExtension());

                $filename = Str::slug($name) . '-' . Str::random(8) . '.' . $ext;

                // 1️⃣ Save original
                $file->storeAs('media', $filename, 'public');

                $width = null;
                $height = null;
                $thumbPath = null;

                // 2️⃣ Generate thumbnail if image
                if ($ext !== 'svg') {
                    $img = $this->image->read(
                        Storage::disk('public')->path("media/{$filename}")
                    );

                    $width  = $img->width();
                    $height = $img->height();

                    $thumb = $img->scaleDown(width: 300);

                    $thumbPath = "media/thumbnails/{$filename}";

                    Storage::disk('public')->put(
                        $thumbPath,
                        (string) $thumb->toJpeg(80)
                    );
                }

                // 3️⃣ Save DB
                $media = Media::create([
                    'name'          => $name,
                    'original_name' => $originalName,
                    'filename'      => $filename,
                    'mime_type'     => $file->getMimeType(),
                    'extension'     => $ext,
                    'size'          => $file->getSize(),
                    'path'          => 'media',
                    'thumbnail_path'=> $thumbPath,
                    'metadata'      => $width ? [
                        'dimensions' => [
                            'width'  => $width,
                            'height' => $height
                        ]
                    ] : null,
                    'uploaded_by'   => auth()->id(),
                    'status'        => 'active'
                ]);

                $saved[] = $media->fresh();

            } catch (\Throwable $e) {

                Log::error('Media upload failed', [
                    'file' => $file->getClientOriginalName(),
                    'error' => $e->getMessage(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Upload gagal: ' . $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'success' => true,
            'data'    => $saved
        ]);
    }

    /* =========================
        UPDATE
    ========================= */
    public function update(Request $request, Media $media)
    {
        $media->update($request->only(['name', 'alt_text', 'description']));

        return response()->json([
            'success' => true,
            'data' => $media->fresh()
        ]);
    }

    /* =========================
       DELETE
    ========================= */
    public function destroy(Media $media)
    {
        Storage::disk('public')->delete("media/{$media->filename}");

        if ($media->thumbnail_path) {
            Storage::disk('public')->delete($media->thumbnail_path);
        }

        $media->delete();

        return response()->json(['success' => true]);
    }

    /* =========================
       UTIL
    ========================= */
    private function formatBytes($bytes)
    {
        $units = ['B','KB','MB','GB'];
        $i = floor(log($bytes, 1024));
        return round($bytes / pow(1024, $i), 2).' '.$units[$i];
    }
}
