<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'sku',
        'name',
        'attribute_options', // JSON: {color: 'Merah', size: 'M'}
        'price',
        'discount_price',
        'discount_start_at',
        'discount_end_at',
        'stock_status',
        'weight',
        'unit',
        'image_id',
        'is_default',
        'sort_order'
    ];

    protected $casts = [
        'attribute_options' => 'array',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'discount_start_at' => 'datetime',
        'discount_end_at' => 'datetime',
        'weight' => 'decimal:2',
        'is_default' => 'boolean',
        'sort_order' => 'integer',
        'image_id' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'image_id');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($variant) {
            if (empty($variant->sku)) {
                $variant->sku = 'SKU-' . strtoupper(\Illuminate\Support\Str::random(6)) . '-' . time();
            }
        });
    }
    
    public function hasActiveDiscount(): bool
    {
        return !is_null($this->discount_price) && 
               $this->discount_start_at && 
               $this->discount_end_at &&
               now()->between($this->discount_start_at, $this->discount_end_at);
    }
    
    public function getSellingPriceAttribute()
    {
        return $this->hasActiveDiscount() ? $this->discount_price : $this->price;
    }
    
    public function getImageUrlAttribute(): ?string
    {
        if ($this->media) {
            return $this->media->url;
        }
        return asset('images/default-product.png');
    }

    public function getFormattedAttributesAttribute(): string
    {
        if (empty($this->attribute_options)) {
            return '';
        }
        
        $attributes = [];
        foreach ($this->attribute_options as $key => $value) {
            $attributes[] = ucfirst($key) . ': ' . ucfirst($value);
        }
        
        return implode(' | ', $attributes);
    }
}