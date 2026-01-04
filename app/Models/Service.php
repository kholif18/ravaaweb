<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\ServiceReview;
use App\Http\Requests\ServiceRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'features',
        'price',
        'price_unit',
        'duration',
        'duration_unit',
        'is_active',
        'is_popular',
        'order',
        'image',
        'gallery',
        'notes',
        'views_count'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_popular' => 'boolean',
        'price' => 'decimal:2',
        'duration' => 'integer',
        'order' => 'integer',
        'views_count' => 'integer',
        'features' => 'array',
        'gallery' => 'array'
    ];

    protected $with = ['category'];

    // Relationship dengan category
    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    // Relationship dengan service requests/orders
    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }

    // Relationship dengan reviews
    public function reviews(): HasMany
    {
        return $this->hasMany(ServiceReview::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    public function scopeInCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        if ($this->price === null) {
            return 'Custom Price';
        }
        
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedDurationAttribute()
    {
        if ($this->duration === null) {
            return 'Negotiable';
        }
        
        return $this->duration . ' ' . $this->duration_unit;
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-service.jpg');
        }
        
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        
        return asset('storage/services/' . $this->image);
    }

    public function getGalleryUrlsAttribute()
    {
        if (!$this->gallery) {
            return [];
        }
        
        return collect($this->gallery)->map(function ($image) {
            if (str_starts_with($image, 'http')) {
                return $image;
            }
            return asset('storage/services/gallery/' . $image);
        })->toArray();
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    // Mutators
    public function setSlugAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['slug'] = Str::slug($this->name);
        } else {
            $this->attributes['slug'] = $value;
        }
    }

    public function setFeaturesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['features'] = json_encode($value);
        } else {
            $this->attributes['features'] = $value;
        }
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function updateCategoryCount()
    {
        if ($this->category) {
            $this->category->updateServicesCount();
        }
    }
}
