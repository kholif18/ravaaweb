<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'color',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });

        static::updating(function ($tag) {
            if ($tag->isDirty('name') && empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }

    /**
     * Color mapping for badge display.
     */
    public static function colorValues(): array
    {
        return [
            'primary' => ['hex' => '#0071e3', 'rgb' => '0,113,227'],
            'success' => ['hex' => '#15803d', 'rgb' => '21,128,61'],
            'info'    => ['hex' => '#0891b2', 'rgb' => '8,145,178'],
            'warning' => ['hex' => '#b45309', 'rgb' => '180,83,9'],
            'danger'  => ['hex' => '#b91c1c', 'rgb' => '185,28,28'],
            'dark'    => ['hex' => '#1e293b', 'rgb' => '30,41,59'],
        ];
    }

    /**
     * Get the CSS hex color for this tag's badge.
     */
    public function getColorHexAttribute(): string
    {
        return self::colorValues()[$this->color]['hex'] ?? '#0071e3';
    }

    /**
     * Get the CSS RGB string for this tag's badge background.
     */
    public function getColorRgbAttribute(): string
    {
        return self::colorValues()[$this->color]['rgb'] ?? '0,113,227';
    }
}
