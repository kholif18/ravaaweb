<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'user_id',
        'reviewer_name',
        'reviewer_email',
        'rating',
        'comment',
        'is_approved',
        'is_featured'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean'
    ];

    // Relationship dengan service
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Relationship dengan user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByService($query, $serviceId)
    {
        return $query->where('service_id', $serviceId);
    }

    public function scopeHighestRated($query)
    {
        return $query->orderBy('rating', 'desc');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getStarRatingAttribute()
    {
        return str_repeat('⭐', $this->rating);
    }

    public function getShortCommentAttribute()
    {
        return strlen($this->comment) > 100 
            ? substr($this->comment, 0, 100) . '...' 
            : $this->comment;
    }

    // Mutators
    public function setRatingAttribute($value)
    {
        // Ensure rating is between 1 and 5
        $this->attributes['rating'] = max(1, min(5, (int)$value));
    }

    // Methods
    public function approve()
    {
        $this->update(['is_approved' => true]);
    }

    public function disapprove()
    {
        $this->update(['is_approved' => false]);
    }

    public function toggleFeatured()
    {
        $this->update(['is_featured' => !$this->is_featured]);
    }
}
