<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\StoreSettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('pages.setting.index', ['current' => get_settings()]);
    }

    public function store(StoreSettingRequest $request)
    {
        collect($request->validated())->each(function ($value, $key) {
            Setting::updateOrCreate(['tec_key' => $key, 'account_id' => auth()->user()->account_id], ['tec_value' => $value]);
        });
        // log_activity(__choice('action_text', ['record' => 'Settings', 'action' => 'saved']), $request, auth()->user(), 'Setting');
        return redirect()->route('settings.index')->with('success', __('messages.update.success'));
    }
}
