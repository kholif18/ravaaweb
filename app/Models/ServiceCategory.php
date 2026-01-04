<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'is_active',
        'order',
        'services_count'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'services_count' => 'integer'
    ];

    /* ======================
    | RELATIONSHIP
     ====================== */
    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }

    /* ======================
    | SCOPES
     ====================== */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    /* ======================
    | ACCESSOR
     ====================== */
    public function getUrlAttribute()
    {
        return route('service-categories.show', $this->slug);
    }

    /* ======================
    | MODEL EVENTS
     ====================== */
    protected static function booted()
    {
        // Auto generate UNIQUE slug saat create
        static::creating(function ($category) {
            if (!empty($category->slug)) {
                return;
            }

            $base = Str::slug($category->name);
            $slug = $base;
            $i = 1;

            while (static::where('slug', $slug)->exists()) {
                $slug = $base . '-' . $i++;
            }

            $category->slug = $slug;
        });

        // Prevent delete if has services
        static::deleting(function ($category) {
            if ($category->services()->exists()) {
                throw new \Exception('Cannot delete category with existing services');
            }
        });
    }

    /* ======================
    | HELPERS
     ====================== */
    public function updateServicesCount()
    {
        $this->updateQuietly([
            'services_count' => $this->services()->count()
        ]);
    }
}
