<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class DailyViewLimit
{
    public function handle(Request $request, Closure $next): Response
    {
        // Get limit from database
        $limit = (int) Setting::get('daily_page_limit', 200);

        // Daily cache key
        $key = 'daily_page_views_' . now()->format('Y_m_d');

        /*
        |--------------------------------------------------------------------------
        | Initialize counter if not exists
        |--------------------------------------------------------------------------
        */
        if (!Cache::has($key)) {
            Cache::put($key, 0, now()->endOfDay());
        }

        /*
        |--------------------------------------------------------------------------
        | Increment page views
        |--------------------------------------------------------------------------
        */
        $views = Cache::increment($key);

        /*
        |--------------------------------------------------------------------------
        | Block if limit exceeded
        |--------------------------------------------------------------------------
        */
        if ($views > $limit) {

            // Option 1: JSON response
            // return response()->json([
            //     'success' => false,
            //     'message' => 'Daily page limit reached',
            //     'limit' => $limit,
            // ], 429);

            // Option 2:
            // return response()->view('limit-reached', [], 429);

            // Option 3:
            abort(429, 'Daily limit reached');
        }

        return $next($request);
    }
}
