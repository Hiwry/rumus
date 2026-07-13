<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::getAllGrouped();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Handle site logo file upload
        if ($request->hasFile('site_logo')) {
            $request->validate([
                'site_logo' => 'image|mimes:jpeg,png,jpg,gif,webp|max:4096'
            ]);
            $file = $request->file('site_logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/uploads'), $filename);
            SiteSetting::set('site_logo', 'images/uploads/' . $filename);
        }

        // Handle site favicon file upload (support .ico, .png, etc.)
        if ($request->hasFile('site_favicon')) {
            $request->validate([
                'site_favicon' => 'file|mimes:ico,png,jpeg,jpg,gif,webp|max:2048'
            ]);
            $file = $request->file('site_favicon');
            $filename = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/uploads'), $filename);
            SiteSetting::set('site_favicon', 'images/uploads/' . $filename);
        }

        $data = $request->except(['_token', '_method', 'site_logo', 'site_favicon']);

        foreach ($data as $key => $value) {
            SiteSetting::set($key, $value);
        }

        // Handle boolean checkboxes (unchecked = not sent)
        $booleanKeys = SiteSetting::where('type', 'boolean')->pluck('key');
        foreach ($booleanKeys as $key) {
            if (!isset($data[$key])) {
                SiteSetting::set($key, '0');
            }
        }

        return back()->with('success', 'Configurações salvas com sucesso!');
    }
}
