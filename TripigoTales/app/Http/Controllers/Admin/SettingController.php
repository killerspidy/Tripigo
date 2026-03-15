<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'gst_enabled' => 'required|boolean',
            'gst_percentage' => 'required|numeric|min:0|max:100',
        ]);

        Setting::updateOrCreate(['key' => 'gst_enabled'], ['value' => $request->gst_enabled]);
        Setting::updateOrCreate(['key' => 'gst_percentage'], ['value' => $request->gst_percentage]);

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
