<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FeedbackController extends Controller
{
    /**
     * Show the tablet-friendly feedback form.
     */
    public function create()
    {
        $services = \App\Models\Services::select('id', 'service')->orderBy('service')->get();
        return view('feedback.create', compact('services'));
    }

    /**
     * Display a listing of feedbacks.
     */
    public function index(Request $request)
    {
        $services = \App\Models\Services::select('id', 'service')->orderBy('service')->get();

        $query = Feedback::with('service')->orderBy('created_at', 'desc');

        if ($request->filled('service_type_id')) {
            $query->where('service_type_id', $request->input('service_type_id'));
        }
        if ($request->filled('citizen_name')) {
            $query->where('citizen_name', 'like', '%'.$request->input('citizen_name').'%');
        }
        if ($request->filled('document_no')) {
            $query->where('document_no', 'like', '%'.$request->input('document_no').'%');
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        $feedbacks = $query->paginate(20)->withQueryString();

        return view('feedback.index', compact('feedbacks', 'services'));
    }

    /**
     * Store feedback submitted from the tablet view.
     */
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

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('feedback.thankyou');
    }

    /**
     * Thank you page after successful submission.
     */
    public function thankyou()
    {
        return view('feedback.thankyou');
    }
}
