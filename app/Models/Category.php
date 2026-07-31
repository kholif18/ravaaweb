<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Traits\CachesQueries;

class Category extends Model
{
    use HasFactory, SoftDeletes, CachesQueries;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'order',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'parent_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'order' => 'integer',
        'parent_id' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get the parent category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('order');
    }

    /**
     * Get the products for the category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to order by order column.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    /**
     * Scope a query to only include root categories (no parent).
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Check if category has parent.
     */
    public function hasParent()
    {
        return !is_null($this->parent_id);
    }

    /**
     * Check if category has children.
     */
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    /**
     * Get all descendants (children, grandchildren, etc.)
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * Get all ancestors (parent, grandparent, etc.)
     */
    public function ancestors()
    {
        $ancestors = collect();
        $category = $this;

        while ($category->parent) {
            $category = $category->parent;
            $ancestors->push($category);
        }

        return $ancestors->reverse();
    }

    /**
     * Color mapping for icon display.
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
     * Get the CSS hex color for this category's icon.
     */
    public function getColorHexAttribute(): string
    {
        return self::colorValues()[$this->color]['hex'] ?? '#0071e3';
    }

    /**
     * Get the CSS RGB string for this category's icon background.
     */
    public function getColorRgbAttribute(): string
    {
        return self::colorValues()[$this->color]['rgb'] ?? '0,113,227';
    }

    /**
     * Get formatted status.
     */
    public function getFormattedStatusAttribute()
    {
        return $this->status === 'active' ? 'Aktif' : 'Tidak Aktif';
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeClassAttribute()
    {
        return [
            'active' => 'success',
            'inactive' => 'danger',
        ][$this->status] ?? 'secondary';
    }

    /**
     * Get full breadcrumb path.
     */
    public function getBreadcrumbAttribute()
    {
        $breadcrumbs = $this->ancestors();
        $breadcrumbs->push($this);
        
        return $breadcrumbs;
    }
}