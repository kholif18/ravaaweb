<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomepageCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
        'icon',
        'title',
        'description',
        'is_active'
    ];

    protected $casts = [
        'position' => 'integer',
        'is_active' => 'boolean'
    ];

    // Scope untuk posisi tertentu
    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    // Scope aktif saja
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk urutan
    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }

    // Accessor untuk icon class
    public function getIconClassAttribute()
    {
        return $this->icon;
    }

    // Mutator untuk memastikan icon ada
    public function setIconAttribute($value)
    {
        $this->attributes['icon'] = $value ?: 'bi-paint-bucket';
    }
}