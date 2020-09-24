<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        return \view('admin.settings.index', [
            'setting' => Setting::first(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $setting = Setting::first();
        $setting->update($request->only('ads_per_day', 'ads_live_day'));

        return back()->with('success', __('admin.messages.updated', ['item' => 'Настройки']));
    }
}
