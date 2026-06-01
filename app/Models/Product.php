<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // BASIC
        'name',
        'slug',
        'sku',
        'category_id',
        'main_media_id',

        // VARIANT
        'has_variants',
        'variant_attributes',

        // CONTENT
        'description',
        'specifications',
        'tags',
        'quick_infos',

        // PRICING
        'price',
        'discount_price',
        'discount_start_at',
        'discount_end_at',

        // STOCK
        'stock_status',

        // SHIPPING
        'weight',
        'length',
        'width',
        'height',
        'unit',

        // FLAGS
        'is_featured',
        'is_best_seller',
        'is_new_arrival',
        'is_digital',

        // SEO
        'meta_title',
        'meta_description',

        // STATUS
        'status',
        'published_at',

        // METRICS
        'view_count',
        'sold_count',
        'order_count',
        'rating_average',
        'rating_count',
    ];

    protected $casts = [
        // NUMERIC
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'rating_average' => 'decimal:2',
        'weight' => 'decimal:2',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',

        // BOOLEAN
        'is_featured' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_new_arrival' => 'boolean',
        'is_digital' => 'boolean',
        'has_variants' => 'boolean',

        // ARRAY / JSON
        'tags' => 'array',
        'quick_infos' => 'array',
        'variant_attributes' => 'array',

        // DATE
        'published_at' => 'datetime',
        'discount_start_at' => 'datetime',
        'discount_end_at' => 'datetime',

        // INTEGER
        'view_count' => 'integer',
        'sold_count' => 'integer',
        'order_count' => 'integer',
        'rating_count' => 'integer',
        'main_media_id' => 'integer',
    ];

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }
    
    public function defaultVariant(): HasOne
    {
        return $this->hasOne(ProductVariant::class)->where('is_default', true);
    }
    
    // Harga terendah dari semua varian
    public function getMinPriceAttribute()
    {
        if (!$this->has_variants) {
            return $this->price;
        }
        
        return $this->variants()->min('price');
    }
    
    // Harga tertinggi dari semua varian
    public function getMaxPriceAttribute()
    {
        if (!$this->has_variants) {
            return $this->price;
        }
        
        return $this->variants()->max('price');
    }
    
    // Mendapatkan varian berdasarkan atribut
    public function getVariantByAttributes($attributes)
    {
        return $this->variants()
            ->where('attribute_options', json_encode($attributes))
            ->first();
    }
    
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }

            if (empty($product->sku)) {
                $product->sku = 'PRD-' . strtoupper(Str::random(8)) . '-' . time();
            }

            if ($product->status === 'published' && empty($product->published_at)) {
                $product->published_at = now();
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }

            if ($product->isDirty('status') && $product->status === 'published' && empty($product->published_at)) {
                $product->published_at = now();
            }
        });
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get related products.
     */
    public function relatedProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_related', 'product_id', 'related_product_id')
            ->withTimestamps()
            ->withPivot('order')
            ->orderByPivot('order');
    }

    /**
     * Scope a query to only include published products.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to order by price.
     */
    public function scopePrice($query, $order = 'asc')
    {
        return $query->orderBy('price', $order);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Check if product has discount.
     */
    public function hasDiscount(): bool
    {
        return !is_null($this->discount_price) && $this->discount_price < $this->price;
    }

    /**
     * Check if product has an active discount.
     */
    public function hasActiveDiscount(): bool
    {
        if ($this->has_variants) {
            return $this->variants()->get()->contains(fn($v) => $v->hasActiveDiscount());
        }

        return !is_null($this->discount_price) && 
               $this->discount_start_at && 
               $this->discount_end_at &&
               now()->between($this->discount_start_at, $this->discount_end_at);
    }

    /**
     * Get selling price (discounted price if active or regular price).
     */
    public function getSellingPriceAttribute()
    {
        if ($this->has_variants) {
            $minPrice = null;
            foreach ($this->variants as $variant) {
                $price = $variant->selling_price;
                if (is_null($minPrice) || $price < $minPrice) {
                    $minPrice = $price;
                }
            }
            return $minPrice ?? $this->price;
        }
        return $this->hasActiveDiscount() ? $this->discount_price : $this->price;
    }

    public function mainMedia(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'main_media_id');
    }

    public function galleryMedia(): BelongsToMany
    {
        return $this->belongsToMany(Media::class, 'product_media')
                    ->wherePivot('type', 'gallery')
                    ->withPivot('sort_order')
                    ->orderBy('product_media.sort_order');
    }

    public function getMainImageUrlAttribute()
    {
        if ($this->mainMedia) {
            return $this->mainMedia->url;
        }
        return asset('storage/images/default-product.png');
    }

    public function getFirstImageUrlAttribute()
    {
        return $this->main_image_url;
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get formatted discount price.
     */
    public function getFormattedDiscountPriceAttribute()
    {
        return 'Rp ' . number_format($this->discount_price, 0, ',', '.');
    }

    /**
     * Get stock status text.
     */
    public function getStockStatusTextAttribute()
    {
        return [
            'in_stock' => 'In Stock',
            'out_of_stock' => 'Out of Stock',
            'pre_order' => 'Pre Order',
        ][$this->stock_status] ?? ucfirst(str_replace('_', ' ', $this->stock_status));
    }

    /**
     * Get stock status badge class.
     */
    public function getStockStatusBadgeClassAttribute()
    {
        return [
            'in_stock' => 'success',
            'out_of_stock' => 'danger',
            'pre_order' => 'warning',
        ][$this->stock_status] ?? 'secondary';
    }
}