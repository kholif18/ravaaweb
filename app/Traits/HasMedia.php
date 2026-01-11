<?php

namespace App\Traits;

use App\Models\Media;
use App\Models\MediaUsage;

trait HasMedia
{
    /**
     * Get all media for this model
     */
    public function media()
    {
        return $this->morphToMany(Media::class, 'model', 'media_usages')
                    ->withPivot('field_name', 'purpose')
                    ->withTimestamps();
    }

    /**
     * Get media for specific field
     */
    public function mediaFor(string $field, string $purpose = null)
    {
        $query = $this->media()->where('field_name', $field);
        
        if ($purpose) {
            $query->where('purpose', $purpose);
        }
        
        return $query;
    }

    /**
     * Get first media for specific field
     */
    public function mediaFirst(string $field, string $purpose = null): ?Media
    {
        return $this->mediaFor($field, $purpose)->first();
    }

    /**
     * Attach media to model
     */
    public function attachMedia($mediaId, string $field, string $purpose = null): bool
    {
        if (is_array($mediaId)) {
            foreach ($mediaId as $id) {
                $this->attachSingleMedia($id, $field, $purpose);
            }
            return true;
        }
        
        return $this->attachSingleMedia($mediaId, $field, $purpose);
    }

    /**
     * Attach single media
     */
    private function attachSingleMedia($mediaId, string $field, string $purpose = null): bool
    {
        // Check if media exists
        $media = Media::find($mediaId);
        if (!$media) {
            return false;
        }

        // Check if already attached
        $existing = $this->media()
            ->where('media_id', $mediaId)
            ->where('field_name', $field)
            ->when($purpose, function ($query) use ($purpose) {
                return $query->where('purpose', $purpose);
            })
            ->exists();

        if ($existing) {
            return false;
        }

        // Attach media
        $this->media()->attach($mediaId, [
            'field_name' => $field,
            'purpose' => $purpose,
        ]);

        // Increment usage count
        $media->incrementUsage();

        return true;
    }

    /**
     * Detach media from model
     */
    public function detachMedia($mediaId, string $field = null, string $purpose = null): bool
    {
        $query = $this->media();
        
        if (is_array($mediaId)) {
            $mediaIds = $mediaId;
        } else {
            $mediaIds = [$mediaId];
        }

        $query->whereIn('media_id', $mediaIds);
        
        if ($field) {
            $query->where('field_name', $field);
        }
        
        if ($purpose) {
            $query->where('purpose', $purpose);
        }

        // Get media before detaching to decrement usage count
        $mediaToDetach = $query->get();

        // Detach
        $detached = $query->detach();

        // Decrement usage count
        foreach ($mediaToDetach as $media) {
            $media->decrementUsage();
        }

        return $detached > 0;
    }

    /**
     * Sync media for specific field
     */
    public function syncMedia(array $mediaIds, string $field, string $purpose = null): array
    {
        // Get current media for this field
        $currentMedia = $this->mediaFor($field, $purpose)->pluck('media_id')->toArray();
        
        // Media to detach
        $detachIds = array_diff($currentMedia, $mediaIds);
        if (!empty($detachIds)) {
            $this->detachMedia($detachIds, $field, $purpose);
        }
        
        // Media to attach
        $attachIds = array_diff($mediaIds, $currentMedia);
        foreach ($attachIds as $mediaId) {
            $this->attachSingleMedia($mediaId, $field, $purpose);
        }
        
        return [
            'attached' => $attachIds,
            'detached' => $detachIds,
        ];
    }

    /**
     * Clear all media for specific field
     */
    public function clearMedia(string $field, string $purpose = null): bool
    {
        $media = $this->mediaFor($field, $purpose)->get();
        $mediaIds = $media->pluck('id')->toArray();
        
        // Detach all media
        $detached = $this->media()
            ->where('field_name', $field)
            ->when($purpose, function ($query) use ($purpose) {
                return $query->where('purpose', $purpose);
            })
            ->detach();
        
        // Decrement usage count
        foreach ($media as $item) {
            $item->decrementUsage();
        }
        
        return $detached > 0;
    }

    /**
     * Get URL of first media for specific field
     */
    public function getMediaUrl(string $field, string $purpose = null): ?string
    {
        $media = $this->mediaFirst($field, $purpose);
        return $media ? $media->url : null;
    }

    /**
     * Get thumbnail URL of first media for specific field
     */
    public function getMediaThumbnailUrl(string $field, string $purpose = null): ?string
    {
        $media = $this->mediaFirst($field, $purpose);
        return $media ? $media->thumbnail_url : null;
    }
}