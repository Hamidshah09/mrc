<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Models\Setting;

class SettingController extends Controller
{

    public function index()
    {
        $todayViews = Cache::get(
            'daily_page_views_' . now()->format('Y_m_d'),
            0
        );

        $currentLimit = Setting::get('daily_page_limit', 200);

        return view('domicile.daily-limit', compact(
            'todayViews',
            'currentLimit'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'limit' => 'required|integer|min:1'
        ]);

        Setting::set('daily_page_limit', $request->limit);

        return back()->with('success', 'Daily limit updated successfully.');
    }
}
