<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavLink extends Model
{
    protected $fillable = [
        'label',
        'parent_id',
        'url',
        'position',
        'target',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(NavLink::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(NavLink::class, 'parent_id')->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function scopeForNavbar($query)
    {
        return $query->where('position', 'navbar')->orWhere('position', 'both');
    }

    public function scopeForMobile($query)
    {
        return $query->where('position', 'mobile')->orWhere('position', 'both');
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    public function isParent(): bool
    {
        return $this->children()->count() > 0;
    }

    public function isChild(): bool
    {
        return $this->parent_id !== null;
    }
}
