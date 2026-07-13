<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    /**
     * Get page by slug or create default structure if it doesn't exist
     */
    public static function getBySlug(string $slug, array $defaultContent = []): self
    {
        return static::firstOrCreate(
            ['slug' => $slug],
            ['content' => $defaultContent]
        );
    }
}
