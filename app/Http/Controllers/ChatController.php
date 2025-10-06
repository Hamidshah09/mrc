<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function ask(Request $request)
    {
        $question = $request->query('question'); // if using GET
        // Or: $request->input('question'); // if using POST

        if ($question) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post($this->apiUrl.'/ask', [
                'question' => $question,
            ]);
            if ($response->successful()) {
                return response()->json($response->json()); // ✅ return JSON to frontend
            } else {
                return response()->json([
                    'error' => 'Failed to submit answer',
                    'details' => $response->body(),
                ], $response->status());
            }
        }

        return response()->json(['error' => 'No question provided'], 400);
    }
    public function pending_answers(Request $request, $id)
    {
        $request->validate([
            'answer'=>'required|max:255|string',
        ]);
        $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post($this->apiUrl.'/admin/answer_pending', [
                'id'     => $id,
                'answer' => $request->answer,
        ]);

        // Optionally handle response
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Answer submitted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to submit answer: '.$response->body());
        }
    }

    public function pending_questions()
    {
        $response = Http::get($this->apiUrl.'/admin/pending');
        $questions = json_decode($response->body());
        // return $questions; 
        return view('chatbot.chat',compact('questions'));
    }
}
