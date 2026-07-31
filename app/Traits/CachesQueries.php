<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

/**
 * Reusable query cache trait.
 * Caches only model IDs to avoid Eloquent serialization issues.
 * Models are always fresh — re-hydrated from DB viawhereIn().
 *
 * Usage: add `use CachesQueries;` to model, then call:
 *   Category::cachedActive()          — returns Collection
 *   Category::cachedActiveOrdered()   — returns Collection (ordered)
 *   Category::invalidateCache()       — manual bust
 */
trait CachesQueries
{
    /**
     * Register auto-invalidation on model events.
     */
    public static function bootCachesQueries(): void
    {
        static::created(fn() => static::invalidateCache());
        static::saved(fn() => static::invalidateCache());
        static::deleted(fn() => static::invalidateCache());
    }

    /**
     * Bust all cache keys for this model.
     */
    public static function invalidateCache(): void
    {
        $prefix = strtolower(class_basename(static::class));
        Cache::forget($prefix . '_ids_active');
        Cache::forget($prefix . '_ids_active_ordered');
        Cache::forget($prefix . '_ids_featured');
    }

    /**
     * Cache key helpers.
     */
    private static function cacheKey(string $suffix): string
    {
        return strtolower(class_basename(static::class)) . '_ids_' . $suffix;
    }

    /**
     * Hydrate models from cached IDs (preserves order).
     */
    private static function hydrateFromIds(array $ids): \Illuminate\Support\Collection
    {
        if (empty($ids)) {
            return collect();
        }

        $models = static::whereIn('id', $ids)->get();

        // Preserve original cached order
        $keyed = $models->keyBy('id');

        return collect($ids)
            ->map(fn($id) => $keyed->get($id))
            ->filter()
            ->values();
    }

    /**
     * Cached active records.
     */
    public static function cachedActive(int $ttl = 3600): \Illuminate\Support\Collection
    {
        $ids = Cache::remember(static::cacheKey('active'), $ttl, function () {
            return static::active()->pluck('id')->toArray();
        });

        return static::hydrateFromIds($ids);
    }

    /**
     * Cached active + ordered records.
     */
    public static function cachedActiveOrdered(int $ttl = 3600): \Illuminate\Support\Collection
    {
        $ids = Cache::remember(static::cacheKey('active_ordered'), $ttl, function () {
            return static::active()->ordered()->pluck('id')->toArray();
        });

        return static::hydrateFromIds($ids);
    }

    /**
     * Cached featured records (only for models with is_featured column).
     */
    public static function cachedFeatured(int $ttl = 3600): \Illuminate\Support\Collection
    {
        $ids = Cache::remember(static::cacheKey('featured'), $ttl, function () {
            return static::active()->where('is_featured', true)->latest()->pluck('id')->toArray();
        });

        return static::hydrateFromIds($ids);
    }
}
