<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SiteSettingController extends Controller
{
    public function index()
    {
        // Group settings by 'group' column for tabs/sections
        $settings = SiteSetting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Handle Delete/Reset Requests first
        if ($request->has('delete_buttons')) {
            foreach ($request->delete_buttons as $key) {
                $setting = SiteSetting::where('key', $key)->first();
                if ($setting && $setting->type === 'image') {
                     // Delete old image if exists and is local
                     if ($setting->value && !str_contains($setting->value, 'http')) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($setting->value);
                    }
                    // Reset to default (Unsplash)
                    $setting->update(['value' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80']);
                }
            }
        }

        // Loop through all inputs (excluding delete buttons and tokens)
        $data = $request->except(['_token', '_method', 'delete_buttons']);

        foreach ($data as $key => $value) {
            $setting = SiteSetting::where('key', $key)->first();
            
            if ($setting) {
                // If this key was just reset, skip normal update if no new file provided
                if ($request->has('delete_buttons') && in_array($key, $request->delete_buttons) && !$request->hasFile($key)) {
                    continue;
                }

                // Handle Image Upload
                if ($request->hasFile($key) && $setting->type === 'image') {
                    // Delete old image if exists and is local (not http)
                    if ($setting->value && !str_contains($setting->value, 'http')) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($setting->value);
                    }
                    
                    $path = $request->file($key)->store('settings', 'public');
                    $setting->update(['value' => $path]);
                }
                // Handle Text (ignore if it's an image input but sent as text)
                elseif ($setting->type !== 'image') {
                    $setting->update(['value' => $value]);
                }
            }
        }

        return redirect()->back()->with('success', 'Pengaturan website berhasil diperbarui.');
    }
}
