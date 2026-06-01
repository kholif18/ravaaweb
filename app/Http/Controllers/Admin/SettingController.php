<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    public function index($group = 'general')
    {
        $settings = Setting::where('group', $group)->get();
        return view("admin.settings.{$group}", compact('settings', 'group'));
    }

    public function update(Request $request): RedirectResponse
    {
        $settings = $request->except('_token', '_method');
        
        foreach ($settings as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
