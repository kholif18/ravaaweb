<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'attributes',
        'sku',
        'price',
        'stock',
        'price_discount',
        'discount_percent',
        'discount_start',
        'discount_end',
        'is_active',
        'is_service',
        'weight',
        'length',
        'width',
        'height',
        'image', // stores media ID
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'price_discount' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_start' => 'datetime',
        'discount_end' => 'datetime',
        'is_active' => 'boolean',
        'is_service' => 'boolean',
        'attributes' => 'array',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the media record for this variant's image.
     * The `image` column stores the media ID (integer).
     */
    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'image');
    }

    /**
     * Get the image URL for this variant.
     * Returns the media URL if linked, or null.
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->media) {
            return $this->media->url;
        }
        // Fallback: if image contains a file path (legacy data)
        if ($this->image && !is_numeric($this->image)) {
            return asset('storage/' . $this->image);
        }
        return null;
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
