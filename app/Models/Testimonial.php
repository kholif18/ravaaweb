<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'position',
        'company',
        'content',
        'avatar_url',
        'rating',
        'is_featured',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'integer'
    ];

    /**
     * Scope a query to only include active testimonials.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured testimonials.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
