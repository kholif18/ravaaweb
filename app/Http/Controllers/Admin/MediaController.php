<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use ZipArchive;

class MediaController extends Controller
{
    private ImageManager $image;

    public function __construct()
    {
        $this->image = new ImageManager(new Driver());
    }

    /* =========================
       INDEX
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
            $m->url = asset('storage/media/'.$m->filename);
            $m->thumbnail_url = $m->thumbnail_path
                ? asset('storage/'.$m->thumbnail_path)
                : $m->url;

            $m->formatted_size = $this->formatBytes($m->size);
        });

        return view('admin.media.index', [
            'media' => $media,
            'mode' => 'manager'
        ]);
    }

    public function picker(Request $request)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $media = Media::query()
            ->when($search, function ($q) use ($search) {
                return $q->where('name', 'like', "%{$search}%")
                        ->orWhere('original_name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(20);

        $media->each(function ($item) {
            $item->url = asset('storage/media/' . $item->filename);
            $item->thumbnail_url = $item->thumbnail_path 
                ? asset('storage/' . $item->thumbnail_path)
                : $item->url;
            $item->formatted_size = $this->formatBytes($item->size);
        });

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.media.partials.media-grid', compact('media'))->render(),
                'currentPage' => $media->currentPage(),
                'totalPages' => $media->lastPage(),
            ]);
        }

        return view('admin.media.picker', compact('media'));
    }

    // public function picker(Request $request)
    // {
    //     $search = $request->get('search');
    //     $page = $request->get('page', 1);
    //     $perPage = 20;
        
    //     $query = Media::query();
        
    //     if ($search) {
    //         $query->where('name', 'like', "%{$search}%")
    //             ->orWhere('original_name', 'like', "%{$search}%");
    //     }
        
    //     $media = $query->orderBy('created_at', 'desc')
    //                 ->paginate($perPage, ['*'], 'page', $page);
        
    //     // Transform data
    //     $media->each(function ($item) {
    //         $item->url = asset('storage/media/'.$item->filename);
    //         $item->thumbnail_url = $item->thumbnail_path
    //             ? asset('storage/'.$item->thumbnail_path)
    //             : $item->url;
            
    //         $item->formatted_size = $this->formatBytes($item->size);
    //     });
        
    //     if ($request->ajax()) {
    //         // Return JSON dengan data untuk modal
    //         return response()->json([
    //             'success' => true,
    //             'html' => view('admin.media.partials.media-grid', compact('media'))->render(),
    //             'totalPages' => $media->lastPage(),
    //             'currentPage' => $media->currentPage(),
    //             'total' => $media->total()
    //         ]);
    //     }
        
    //     return view('admin.media.picker', [
    //         'media' => $media,
    //         'mode' => 'picker'
    //     ]);
    // }

    public function getBatch(Request $request)
    {
        $ids = explode(',', $request->get('ids', ''));
        
        $media = Media::whereIn('id', $ids)
                    ->get(['id', 'name', 'path', 'thumbnail_path as thumbnail']);
        
        return response()->json($media);
    }

    /* =========================
       SHOW
    ========================= */
    public function show(Media $media)
    {
        $media->url = asset('storage/media/'.$media->filename);
        $media->thumbnail_url = $media->thumbnail_path
            ? asset('storage/'.$media->thumbnail_path)
            : $media->url;

        return response()->json($media);
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
            return response()->json(['success'=>false,'errors'=>$validator->errors()],422);
        }

        $saved = [];

        foreach ($request->file('files') as $file) {
            try {
                $originalName = $file->getClientOriginalName();
                $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $ext = strtolower($file->getClientOriginalExtension());
                $filename = Str::slug($name).'-'.Str::random(6).'.'.$ext;

                $file->storeAs('media', $filename, 'public');

                $thumbPath = null;
                $width = null;
                $height = null;

                if ($ext !== 'svg') {
                    $img = $this->image->read(Storage::disk('public')->path("media/$filename"));
                    $width = $img->width();
                    $height = $img->height();

                    $thumb = $img->scaleDown(width:300);
                    $thumbPath = "media/thumbnails/$filename";
                    Storage::disk('public')->put($thumbPath, (string)$thumb->toJpeg(80));
                }

                $saved[] = Media::create([
                    'name' => $name,
                    'original_name' => $originalName, 
                    'filename' => $filename,
                    'extension' => $ext,
                    'size' => $file->getSize(),
                    'path' => 'media',
                    'thumbnail_path' => $thumbPath,
                    'mime_type' => $file->getMimeType(),
                    'metadata' => $width ? ['dimensions'=>['w'=>$width,'h'=>$height]] : null,
                    'uploaded_by' => Auth::id(),
                    'status' => 'active'
                ]);

            } catch (\Throwable $e) {
                Log::error($e);
                return response()->json(['success'=>false,'message'=>$e->getMessage()],500);
            }
        }

        return response()->json(['success'=>true,'data'=>$saved]);
    }

    /* =========================
       UPLOAD
    ========================= */
    public function upload(Request $request)
    {
        // Validasi untuk single file upload (media picker)
        $validator = Validator::make($request->all(), [
            'files' => ['sometimes', 'array'], // Untuk multiple upload dari form produk
            'files.*' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],
            'file' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'], // Untuk single upload dari media picker
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Handle single file upload (dari media picker)
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                return $this->processSingleFile($file);
            }
            
            // Handle multiple file upload (dari form produk)
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                $results = [];
                
                foreach ($files as $file) {
                    $result = $this->processSingleFile($file);
                    if ($result->getStatusCode() === 200) {
                        $results[] = json_decode($result->getContent());
                    }
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Semua file berhasil diupload',
                    'files' => $results
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada file yang diupload'
            ], 400);

        } catch (\Throwable $e) {
            Log::error('Upload error: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupload file',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    private function processSingleFile($file)
    {
        $originalName = $file->getClientOriginalName();
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext = strtolower($file->getClientOriginalExtension());
        $filename = Str::slug($name) . '-' . Str::random(6) . '.' . $ext;

        // Simpan file
        $file->storeAs('media', $filename, 'public');

        $thumbPath = null;
        $width = null;
        $height = null;
        $thumbnailUrl = null;
        $fileUrl = asset('storage/media/' . $filename);

        // Generate thumbnail untuk non-SVG
        if ($ext !== 'svg') {
            try {
                $img = $this->image->read(Storage::disk('public')->path("media/$filename"));
                $width = $img->width();
                $height = $img->height();

                $thumb = $img->scaleDown(width: 300);
                $thumbPath = "media/thumbnails/$filename";
                Storage::disk('public')->put($thumbPath, (string) $thumb->toJpeg(80));
                
                $thumbnailUrl = asset('storage/' . $thumbPath);
            } catch (\Throwable $e) {
                Log::error('Thumbnail generation failed in processSingleFile: ' . $e->getMessage());
                $thumbnailUrl = $fileUrl;
            }
        } else {
            // Untuk SVG, gunakan file asli sebagai thumbnail
            $thumbnailUrl = $fileUrl;
        }

        // Simpan ke database
        $media = Media::create([
            'name' => $name,
            'original_name' => $originalName,
            'filename' => $filename,
            'extension' => $ext,
            'size' => $file->getSize(),
            'path' => 'media',
            'thumbnail_path' => $thumbPath,
            'mime_type' => $file->getMimeType(),
            'metadata' => $width ? ['dimensions' => ['w' => $width, 'h' => $height]] : null,
            'uploaded_by' => Auth::id(),
            'status' => 'active'
        ]);

        // Response khusus untuk media picker
        return response()->json([
            'success' => true,
            'message' => 'File berhasil diupload',
            'media' => [
                'id' => $media->id,
                'url' => $fileUrl,
                'thumbnail_url' => $thumbnailUrl,
                'name' => $media->name,
                'original_name' => $media->original_name,
                'size' => $media->size,
                'formatted_size' => $this->formatBytes($media->size),
                'extension' => $media->extension,
                'mime_type' => $media->mime_type,
                'created_at' => $media->created_at->format('Y-m-d H:i'),
                'dimensions' => $width ? "{$width}x{$height}" : null,
            ]
        ]);
    }

    /* =========================
       DELETE
    ========================= */
    public function destroy(Media $media)
    {
        Storage::disk('public')->delete("media/{$media->filename}");
        if ($media->thumbnail_path) Storage::disk('public')->delete($media->thumbnail_path);
        $media->delete();

        return response()->json(['success'=>true]);
    }

    /* =========================
       BULK DELETE
    ========================= */
    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids'=>'required|array']);
        $media = Media::whereIn('id',$request->ids)->get();

        foreach($media as $m){
            Storage::disk('public')->delete("media/$m->filename");
            if($m->thumbnail_path) Storage::disk('public')->delete($m->thumbnail_path);
            $m->delete();
        }

        return response()->json(['success'=>true]);
    }

    /* =========================
       BULK DOWNLOAD
    ========================= */
    public function bulkDownload(Request $request)
    {
        $request->validate(['ids'=>'required|array']);
        $files = Media::whereIn('id',$request->ids)->get();

        $zip = new ZipArchive;
        $zipName = 'media-'.time().'.zip';
        $zipPath = storage_path("app/public/$zipName");

        $zip->open($zipPath, ZipArchive::CREATE);
        foreach($files as $f){
            $zip->addFile(Storage::disk('public')->path("media/$f->filename"), $f->filename);
        }
        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend();
    }

    /* =========================
       SEARCH (AJAX)
    ========================= */
    public function search(Request $request)
    {
        return Media::where('name','like','%'.$request->q.'%')->get();
    }

    /* =========================
       STATS
    ========================= */
    public function getStats()
    {
        return response()->json([
            'total' => Media::count(),
            'size' => Media::sum('size'),
            'images' => Media::whereIn('extension',['jpg','png','jpeg','webp'])->count()
        ]);
    }

    /* =========================
       DOWNLOAD SINGLE
    ========================= */
    public function download(Media $media)
    {
        return Storage::disk('public')->download("media/$media->filename");
    }

    /* =========================
       REGENERATE THUMBNAILS
    ========================= */
    public function regenerateThumbnails()
    {
        $media = Media::whereNotNull('thumbnail_path')->get();

        foreach($media as $m){
            $img = $this->image->read(Storage::disk('public')->path("media/$m->filename"));
            $thumb = $img->scaleDown(width:300);
            Storage::disk('public')->put($m->thumbnail_path,(string)$thumb->toJpeg(80));
        }

        return response()->json(['success'=>true]);
    }

    /* =========================
       UTIL
    ========================= */
    private function formatBytes($bytes)
    {
        $units=['B','KB','MB','GB'];
        $i=floor(log($bytes,1024));
        return round($bytes/pow(1024,$i),2).' '.$units[$i];
    }
}

