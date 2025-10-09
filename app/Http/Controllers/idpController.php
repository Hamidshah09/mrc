<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IDPController extends Controller
{
    protected $fastapiUrl;

    public function __construct()
    {
        // point this to your server's FastAPI base URL
        $this->fastapiUrl = env('FASTAPI_URL', 'http://127.0.0.1:8000');
    }
    public function index(Request $request)
    {
        $keyword = $request->query('keyword', '');
        $response = Http::get("{$this->fastapiUrl}/home", [
            'keyword' => $keyword
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch records'], 500);
        }
        
        $data = $response->json();
        $records = $data['records'] ?? [];
        return view('idp.index', compact('records'));
    }
    public function show($app_id)
    {
        $response = Http::get("{$this->fastapiUrl}/profile/{$app_id}");

        if ($response->failed()) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        return $response->json();
    }

    public function update($app_id)
    {   
        $parts = explode("-", $app_id);
        $id = end($parts);
        
        $response = Http::post("{$this->fastapiUrl}/approve/{$id}");
        
        if ($response->failed()) {
            return redirect()->route('idp.index')->with('error','failed');
        }
        // Match what your JS expects
        return redirect()->route('idp.index')->with('success','Application Approved');
    }
    public function check(Request $request)
    {
        session()->forget('status');
        session()->forget('error');

        $request->validate([
            'idp' => ['required', 'integer']
        ]);

        try {
            $response = Http::get($this->fastapiUrl.'/idp/check/'. $request->idp);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['error'])) {
                    return redirect()->back()->with('error', $data['error']);
                }

                // unwrap 'status' if FastAPI returns { "status": {...} }
                if (isset($data['result'])) {
                    return redirect()->back()->with('status', $data['result']);
                }

                return redirect()->back()->with('status', $data);
            } else {
                $error = $response->json()['error'] ?? $response->json()['detail'] ?? 'Unknown error from API';
                return redirect()->back()->with('error', $error);
            }
        } catch (\Exception $e) {
            \Log::error('API call failed: '.$e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }

}
