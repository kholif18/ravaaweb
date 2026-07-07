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
     * Set a setting value.
     */
    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('settings');
    }

    /**
     * Set multiple settings at once.
     */
    public static function setMany(array $data): void
    {
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
