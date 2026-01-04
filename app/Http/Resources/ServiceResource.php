<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'features' => $this->features ?? [],
            'price' => $this->price,
            'formatted_price' => $this->formatted_price,
            'price_unit' => $this->price_unit,
            'duration' => $this->duration,
            'formatted_duration' => $this->formatted_duration,
            'duration_unit' => $this->duration_unit,
            'is_active' => $this->is_active,
            'is_popular' => $this->is_popular,
            'order' => $this->order,
            'image' => $this->image_url,
            'gallery' => $this->gallery_urls,
            'notes' => $this->notes,
            'views_count' => $this->views_count,
            'average_rating' => $this->average_rating,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            
            // Relationships
            'category' => new ServiceCategoryResource($this->whenLoaded('category')),
            
            // Links
            'links' => [
                'self' => route('api.services.show', $this->slug),
                'category' => route('api.service-categories.show', $this->category->slug),
                'request_service' => route('api.service-requests.store')
            ]
        ];
    }
}
