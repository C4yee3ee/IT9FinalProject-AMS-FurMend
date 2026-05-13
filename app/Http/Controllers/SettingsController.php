<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingsRequest;
use App\Models\AppSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(): View
    {
        return view('settings.edit', [
            'settings' => AppSetting::allAsMap(),
        ]);
    }

    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        AppSetting::updateFromArray($request->validated());

        return back()->with('success', 'System settings saved successfully.');
    }
}
