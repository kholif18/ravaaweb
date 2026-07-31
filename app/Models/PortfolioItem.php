<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use App\Traits\CachesQueries;

class PortfolioItem extends Model
{
    use CachesQueries;
    protected static function booted(): void
    {
        static::creating(function (PortfolioItem $item) {
            if (empty($item->slug)) {
                $item->slug = Str::slug($item->title);
            }
        });

        static::updating(function (PortfolioItem $item) {
            if (empty($item->slug)) {
                $item->slug = Str::slug($item->title);
            }
        });
    }

    protected $fillable = [
        'title',
        'slug',
        'category',
        'client',
        'description',
        'image',
        'image_media_id',
        'tech',
        'project_url',
        'is_featured',
        'order',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'tech' => 'array',
        'is_featured' => 'boolean',
    ];

    public function imageMedia(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'image_media_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('title');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Accessor for image URL
    public function getImageUrlAttribute(): ?string
    {
        if ($this->imageMedia) {
            return $this->imageMedia->url;
        }
        if (!$this->image) {
            return null;
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }
}
