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
        'discount_start',
        'discount_end',
        'stock_quantity',
        'weight',
        'image',
        'is_default',
        'sort_order'
    ];

    protected $casts = [
        'attribute_options' => 'array',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'discount_start' => 'datetime',
        'discount_end' => 'datetime',
        'stock_quantity' => 'integer',
        'weight' => 'decimal:2',
        'is_default' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    
    // Scope untuk diskon aktif
    public function scopeActiveDiscount($query)
    {
        return $query->whereNotNull('discount_price')
            ->where('discount_start', '<=', now())
            ->where('discount_end', '>=', now());
    }   
    
    // Mendapatkan harga jual
    public function getSellingPriceAttribute()
    {
        if ($this->hasActiveDiscount()) {
            return $this->discount_price;
        }
        return $this->price;
    }
    
    // Cek apakah diskon aktif
    public function hasActiveDiscount(): bool
    {
        return $this->discount_price && 
               $this->discount_start && 
               $this->discount_end &&
               now()->between($this->discount_start, $this->discount_end);
    }
    
    // Mendapatkan persentase diskon
    public function getDiscountPercentageAttribute()
    {
        if (!$this->hasActiveDiscount() || $this->price <= 0) {
            return 0;
        }
        
        $discountAmount = $this->price - $this->discount_price;
        return round(($discountAmount / $this->price) * 100, 2);
    }

    /**
     * Get variant image URL.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }
        
        // Cek apakah full URL
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        $path = 'variants/' . $this->image;
        
        // Cek di storage
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }
        
        // Cek di public path
        $publicPath = 'storage/' . $path;
        if (file_exists(public_path($publicPath))) {
            return asset($publicPath);
        }
        
        return null;
    }

    /**
     * Get formatted attribute options.
     */
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
