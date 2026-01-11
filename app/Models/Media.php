<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Media extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'filename',
        'original_name',
        'mime_type',
        'extension',
        'size',
        'path',
        'thumbnail_path',
        'alt_text',
        'description',
        'status',
        'metadata',
        'usage_count',
        'uploaded_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'size' => 'integer',
        'usage_count' => 'integer',
        'metadata' => 'array',
        'uploaded_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Event ketika media dihapus
        static::deleting(function ($media) {
            if ($media->isForceDeleting()) {
                // Hapus file fisik jika hard delete
                $media->deletePhysicalFiles();
            }
        });

        // Event setelah media dihapus (soft delete)
        static::deleted(function ($media) {
            if (!$media->isForceDeleting()) {
                // Update status menjadi deleted untuk soft delete
                $media->update(['status' => 'deleted']);
            }
        });

        // Event ketika media di-restore
        static::restored(function ($media) {
            $media->update(['status' => 'active']);
        });
    }

    /**
     * Scope untuk media aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope untuk media gambar (bukan dokumen)
     */
    public function scopeImages($query)
    {
        return $query->whereIn('extension', ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('original_name', 'like', "%{$search}%")
              ->orWhere('filename', 'like', "%{$search}%")
              ->orWhere('alt_text', 'like', "%{$search}%");
        });
    }

    /**
     * Scope untuk filter berdasarkan ekstensi
     */
    public function scopeByExtension($query, $extension)
    {
        if (is_array($extension)) {
            return $query->whereIn('extension', $extension);
        }
        return $query->where('extension', $extension);
    }

    /**
     * Scope untuk filter berdasarkan ukuran
     */
    public function scopeBySize($query, $min = null, $max = null)
    {
        if ($min) {
            $query->where('size', '>=', $min);
        }
        if ($max) {
            $query->where('size', '<=', $max);
        }
        return $query;
    }

    /**
     * Scope untuk urutan berdasarkan penggunaan
     */
    public function scopeMostUsed($query, $limit = 10)
    {
        return $query->orderBy('usage_count', 'desc')->limit($limit);
    }

    /**
     * Scope untuk urutan berdasarkan yang baru
     */
    public function scopeNewest($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Scope untuk urutan berdasarkan ukuran
     */
    public function scopeLargest($query, $limit = 10)
    {
        return $query->orderBy('size', 'desc')->limit($limit);
    }

    /**
     * Get the full URL of the media file
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path . '/' . $this->filename);
    }

    /**
     * Get the full URL of the thumbnail
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->thumbnail_path && Storage::disk('public')->exists($this->thumbnail_path)) {
            return asset('storage/' . $this->thumbnail_path);
        }
        
        // Fallback ke file asli jika thumbnail tidak ada
        return $this->url;
    }

    /**
     * Get the full path of the media file
     */
    public function getFullPathAttribute(): string
    {
        return storage_path('app/public/' . $this->path . '/' . $this->filename);
    }

    /**
     * Get the full path of the thumbnail
     */
    public function getThumbnailFullPathAttribute(): ?string
    {
        if ($this->thumbnail_path) {
            return storage_path('app/public/' . $this->thumbnail_path);
        }
        return null;
    }

    /**
     * Get formatted file size (KB, MB, GB)
     */
    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 1) . ' ' . $units[$pow];
    }

    /**
     * Get image dimensions if available
     */
    public function getDimensionsAttribute(): ?array
    {
        return $this->metadata['dimensions'] ?? $this->metadata ?? null;
    }

    /**
     * Get image width
     */
    public function getWidthAttribute(): ?int
    {
        return $this->dimensions['width'] ?? $this->metadata['width'] ?? null;
    }

    /**
     * Get image height
     */
    public function getHeightAttribute(): ?int
    {
        return $this->dimensions['height'] ?? $this->metadata['height'] ?? null;
    }

    /**
     * Get image aspect ratio
     */
    public function getAspectRatioAttribute(): ?float
    {
        if ($this->width && $this->height) {
            return round($this->width / $this->height, 2);
        }
        return null;
    }

    /**
     * Check if media is an image
     */
    public function getIsImageAttribute(): bool
    {
        return in_array($this->extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
    }

    /**
     * Check if media has thumbnail
     */
    public function getHasThumbnailAttribute(): bool
    {
        return !empty($this->thumbnail_path) && Storage::exists('public/' . $this->thumbnail_path);
    }

    /**
     * Get the user who uploaded the media
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get all usages of this media
     */
    public function usages()
    {
        return $this->hasMany(MediaUsage::class);
    }

    /**
     * Get all models that use this media (polymorphic)
     */
    public function models()
    {
        return $this->morphedByMany(Media::class, 'model', 'media_usages');
    }

    /**
     * Increment usage count
     */
    public function incrementUsage(): self
    {
        $this->increment('usage_count');
        return $this;
    }

    /**
     * Decrement usage count
     */
    public function decrementUsage(): self
    {
        if ($this->usage_count > 0) {
            $this->decrement('usage_count');
        }
        return $this;
    }

    /**
     * Delete physical files from storage
     */
    public function deletePhysicalFiles(): bool
    {
        try {
            // Delete main file
            if (Storage::exists('public/' . $this->path . '/' . $this->filename)) {
                Storage::delete('public/' . $this->path . '/' . $this->filename);
            }
            
            // Delete thumbnail if exists
            if ($this->thumbnail_path && Storage::disk('public')->exists($this->thumbnail_path)) {
                Storage::delete('public/' . $this->thumbnail_path);
            }
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to delete media files: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get file info as array
     */
    public function toFileArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'filename' => $this->filename,
            'url' => $this->url,
            'thumbnail_url' => $this->thumbnail_url,
            'size' => $this->formatted_size,
            'size_bytes' => $this->size,
            'extension' => $this->extension,
            'mime_type' => $this->mime_type,
            'width' => $this->width,
            'height' => $this->height,
            'aspect_ratio' => $this->aspect_ratio,
            'alt_text' => $this->alt_text,
            'description' => $this->description,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_at_human' => $this->created_at->diffForHumans(),
        ];
    }
}