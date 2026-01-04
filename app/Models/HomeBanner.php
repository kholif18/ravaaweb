<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'button1_text',
        'button1_link',
        'button2_text',
        'button2_link',
    ];

    /**
     * Get the full image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Check if it's a full URL or local path
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            
            // For local storage
            return asset('storage/' . $this->image);
        }
        
        // Return default image if no image set
        return 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';
    }

    /**
     * Check if banner has image
     */
    public function hasImage()
    {
        return !empty($this->image);
    }
}
