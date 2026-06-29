<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'features',
        'price',
        'price_discount',
        'discount_percent',
        'discount_start',
        'discount_end',
        'stock',
        'is_service',
        'variant_types',
        'category_id',
        'status',
        'is_featured',
        'sku',
        'weight',
        'length',
        'width',
        'height',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'thumbnail_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'price_discount' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_start' => 'datetime',
        'discount_end' => 'datetime',
        'is_featured' => 'boolean',
        'is_service' => 'boolean',
        'features' => 'array',
        'variant_types' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function (Product $product) {
            if ($product->wasChanged('name') && empty($product->getOriginal('slug'))) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'product_tag')->withTimestamps();
    }

    public function media(): BelongsToMany
    {
        return $this->belongsToMany(Media::class, 'product_media')
            ->withPivot('sort_order', 'is_primary')
            ->withTimestamps()
            ->orderByPivot('sort_order');
    }

    public function thumbnail(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'thumbnail_id');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function primaryImage(): ?Media
    {
        $primary = $this->media()->wherePivot('is_primary', true)->first();
        return $primary ?? $this->media()->first();
    }

    public function getEffectivePriceAttribute(): float
    {
        if ($this->price_discount && $this->price_discount > 0) {
            return (float) $this->price_discount;
        }
        return (float) $this->price;
    }

    public function getDiscountActiveAttribute(): bool
    {
        if (!$this->discount_percent || $this->discount_percent <= 0) {
            return false;
        }
        $now = now();
        if ($this->discount_start && $now->lt($this->discount_start)) {
            return false;
        }
        if ($this->discount_end && $now->gt($this->discount_end)) {
            return false;
        }
        return true;
    }
}
