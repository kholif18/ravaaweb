<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::allAsArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name'          => 'nullable|string|max:255',
            'site_tagline'       => 'nullable|string|max:255',
            'site_description'   => 'nullable|string',
            'whatsapp'           => 'nullable|string|max:50',
            'whatsapp_message'   => 'nullable|string|max:500',
            'email'              => 'nullable|email|max:255',
            'phone'              => 'nullable|string|max:50',
            'address'            => 'nullable|string',
            'operating_hours'    => 'nullable|string|max:255',
            'instagram'          => 'nullable|string|max:255',
            'facebook'           => 'nullable|string|max:255',
            'linkedin'           => 'nullable|string|max:255',
            'tiktok'             => 'nullable|string|max:255',
            'youtube'            => 'nullable|string|max:255',
            'hero_title'         => 'nullable|string|max:255',
            'hero_subtitle'      => 'nullable|string',
            'hero_image'         => 'nullable|string|max:500',
            'hero_cta_text'      => 'nullable|string|max:100',
            'hero_cta_url'       => 'nullable|string|max:500',
            'hero_badge'         => 'nullable|string|max:255',
            'meta_title'         => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string|max:500',
            'meta_keywords'      => 'nullable|string|max:255',
            'footer_text'        => 'nullable|string',
            'copyright'          => 'nullable|string|max:255',
        ]);

        Setting::setMany(array_filter($validated, fn($v) => $v !== null));

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan!');
    }
}
