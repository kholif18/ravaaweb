<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Base URLs for social media platforms
     */
    private const SOCIAL_BASE_URLS = [
        'instagram' => 'https://www.instagram.com/',
        'facebook'  => 'https://www.facebook.com/',
        'linkedin'  => 'https://www.linkedin.com/',
        'tiktok'    => 'https://www.tiktok.com/@',
        'youtube'   => 'https://www.youtube.com/@',
    ];

    /**
     * Strip base URL prefix to get username only
     */
    public static function stripSocialPrefix(string $platform, ?string $value): string
    {
        if (empty($value)) {
            return '';
        }

        $baseUrl = self::SOCIAL_BASE_URLS[$platform] ?? null;
        if ($baseUrl && str_starts_with($value, $baseUrl)) {
            return substr($value, strlen($baseUrl));
        }

        return $value;
    }

    public function index()
    {
        $settings = Setting::allAsArray();

        // Strip base URL for display (show only username)
        foreach (self::SOCIAL_BASE_URLS as $platform => $baseUrl) {
            if (!empty($settings[$platform])) {
                $settings[$platform] = self::stripSocialPrefix($platform, $settings[$platform]);
            }
        }

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name'          => 'nullable|string|max:255',
            'logo_media_id'      => 'nullable|integer|exists:media,id',
            'site_tagline'       => 'nullable|string|max:255',
            'site_description'   => 'nullable|string',
            'whatsapp'           => 'nullable|string|max:50',
            'whatsapp_message'   => 'nullable|string|max:500',
            'email'              => 'nullable|email|max:255',
            'phone'              => 'nullable|string|max:50',
            'address'            => 'nullable|string',
            'operating_hours'    => 'nullable|string|max:255',
            'map_embed'          => 'nullable|string|max:1000',
            'instagram'          => 'nullable|string|max:255',
            'facebook'           => 'nullable|string|max:255',
            'linkedin'           => 'nullable|string|max:255',
            'tiktok'             => 'nullable|string|max:255',
            'youtube'            => 'nullable|string|max:255',
            'meta_title'         => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string|max:500',
            'meta_keywords'      => 'nullable|string|max:255',
            'footer_text'        => 'nullable|string',
            'copyright'          => 'nullable|string|max:255',
        ]);

        // Prepend base URL for social media fields if not already a full URL
        foreach (self::SOCIAL_BASE_URLS as $platform => $baseUrl) {
            if (!empty($validated[$platform])) {
                $value = $validated[$platform];
                // If value doesn't start with http, treat it as username and prepend base URL
                if (!str_starts_with($value, 'http://') && !str_starts_with($value, 'https://')) {
                    $validated[$platform] = $baseUrl . $value;
                }
            }
        }

        Setting::setMany(array_filter($validated, fn($v) => $v !== null));

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan!');
    }
}
