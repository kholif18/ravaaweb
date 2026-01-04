<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceCategoryResource extends JsonResource
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
            'icon' => $this->icon,
            'color' => $this->color,
            'is_active' => $this->is_active,
            'order' => $this->order,
            'services_count' => $this->services_count,
            'url' => $this->url,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            
            // Relationships (hanya di-load jika diminta)
            'services' => $this->whenLoaded('services', function () {
                return ServiceResource::collection($this->services);
            }),
            
            // Links
            'links' => [
                'self' => route('api.service-categories.show', $this->slug),
                'services' => route('api.services.index', ['category' => $this->slug])
            ]
        ];
    }
}
