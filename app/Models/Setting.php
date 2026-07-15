<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key.
     * Uses Cache for performance.
     */
    public static function get(string $key, $default = null)
    {
        $settings = Cache::remember('settings', 3600, function () {
            return static::pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    /**
     * Forget cached logo URLs for a given media ID (or all known).
     */
    private static function forgetLogoCache(?string $mediaId = null): void
    {
        if ($mediaId) {
            Cache::forget('logo_url_' . $mediaId);
        } else {
            // When we don't know the old ID, clear the settings cache
            // so the next head/sidebar render re-fetches.
            Cache::forget('settings');
        }
    }

    /**
     * Set a setting value.
     */
    public static function set(string $key, $value): void
    {
        if ($key === 'logo_media_id') {
            // Clear old logo cache
            $oldId = static::get('logo_media_id');
            if ($oldId) {
                Cache::forget('logo_url_' . $oldId);
            }
        }
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('settings');
    }

    /**
     * Set multiple settings at once.
     */
    public static function setMany(array $data): void
    {
        if (array_key_exists('logo_media_id', $data)) {
            $oldId = static::get('logo_media_id');
            if ($oldId) {
                Cache::forget('logo_url_' . $oldId);
            }
        }
        foreach ($data as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget('settings');
    }

    /**
     * Get all settings as key-value array.
     */
    public static function allAsArray(): array
    {
        return Cache::remember('settings', 3600, function () {
            return static::pluck('value', 'key')->toArray();
        });
    }
}
