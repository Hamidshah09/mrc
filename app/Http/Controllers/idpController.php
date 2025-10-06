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
        $this->fastapiUrl = env('FASTAPI_URL', 'http://127.0.0.1:5500/idp');
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

}
