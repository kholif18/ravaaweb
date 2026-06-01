<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class PortfolioItem extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'client',
        'year',
        'image_url',
        'tags',
        'order',
        'is_active'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active items.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            if (empty($item->slug)) {
                $item->slug = Str::slug($item->title);
            }
        });
    }
}
