<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackApiController extends Controller
{
    public function services()
    {
        return response()->json(
            \App\Models\Services::select('id','service')
                ->orderBy('service')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_type_id' => 'nullable|integer',
            'document_no' => 'nullable|string|max:255',
            'citizen_name' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'suggestions' => 'required|string',
        ]);

        Feedback::create($data);

        return response()->json([
            'success' => true
        ]);
    }
}
