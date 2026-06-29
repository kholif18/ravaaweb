<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file_name',
        'mime_type',
        'size',
        'path',
        'disk',
        'uploaded_by',
    ];

    protected $appends = ['url', 'human_size', 'extension'];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_media')
            ->withPivot('sort_order', 'is_primary')
            ->withTimestamps();
    }

    public function getUrlAttribute(): string
    {
        if ($this->disk === 's3') {
            return Storage::disk('s3')->url($this->path);
        }
        return Storage::disk('public')->url($this->path);
    }

    public function getHumanSizeAttribute(): string
    {
        $bytes = $this->size;
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        } elseif ($bytes >= 1024) {
            return round($bytes / 1024, 1) . ' KB';
        }
        return $bytes . ' B';
    }

    public function getExtensionAttribute(): string
    {
        return pathinfo($this->file_name, PATHINFO_EXTENSION);
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function isVideo(): bool
    {
        return str_starts_with($this->mime_type, 'video/');
    }

    public function isAudio(): bool
    {
        return str_starts_with($this->mime_type, 'audio/');
    }

    public function isDocument(): bool
    {
        return in_array($this->mime_type, [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/plain',
        ]);
    }

    public function deleteFile(): void
    {
        if (empty($this->path)) {
            return;
        }

        if ($this->disk === 's3') {
            Storage::disk('s3')->delete($this->path);
        } else {
            Storage::disk('public')->delete($this->path);
        }
    }
}
