<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftwareHouseService extends Model
{
    protected $fillable = [
        'title',
        'icon',
        'steps',
        'order',
        'is_active',
    ];

    protected $casts = [
        'steps' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (is_null($model->order)) {
                $model->order = (static::max('order') ?? 0) + 1;
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('id');
    }
}
