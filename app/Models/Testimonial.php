<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    protected $fillable = [
        'client_name',
        'position',
        'company',
        'content',
        'rating',
        'image_media_id',
        'status',
        'order',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function imageMedia(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'image_media_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('id');
    }

    public function getImageUrlAttribute(): ?string
    {
        if ($this->imageMedia) {
            return $this->imageMedia->url;
        }
        return null;
    }
}
