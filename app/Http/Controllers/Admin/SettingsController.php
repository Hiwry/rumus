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
        // Handle image/file uploads dynamically
        $fileFields = ['site_logo', 'site_favicon', 'quote_logo', 'quote_stamp', 'quote_signature'];
        
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $prefix = str_replace(['site_', 'quote_'], '', $field);
                $filename = $prefix . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/uploads'), $filename);
                SiteSetting::set($field, 'images/uploads/' . $filename);
            }
        }

        $data = $request->except(array_merge(['_token', '_method'], $fileFields));

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
