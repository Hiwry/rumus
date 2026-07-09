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
        $data = $request->except(['_token', '_method']);

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
