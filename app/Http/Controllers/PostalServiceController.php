<?php

namespace App\Http\Controllers;

use App\Models\PostalService;
use App\Models\PostalStatuses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostalServiceController extends Controller
{
    /**
     * Show the form for creating a new postal service record
     */
    public function create()
    {
        $statuses = PostalStatuses::all();
        return view('postalservice.create', compact('statuses'));
    }

    /**
     * Store a newly created postal service record in the database
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'receiver_name' => 'required|string|max:255',
            'receiver_address' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
        ]);

        // Add the authenticated user's ID;
        $validated['status_id'] = 1; // Default status (e.g., "In Transit")
        $validated['weight'] = '20';
        $validated['rate'] = 160;
        // Create the record
        PostalService::create($validated);

        return redirect()->route('postalservice.create')->with('success', 'Postal service record created successfully.');
    }

    /**
     * Display all postal service records
     */
    public function index(Request $request)
    {
        $query = PostalService::with('status');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $searchType = $request->search_type ?? 'article_number';

            if ($searchType === 'article_number') {
                $query->where('article_number', 'like', '%' . $search . '%');
            } elseif ($searchType === 'receiver_name') {
                $query->where('receiver_name', 'like', '%' . $search . '%');
            } elseif ($searchType === 'receiver_address') {
                $query->where('receiver_address', 'like', '%' . $search . '%');
            } elseif ($searchType === 'phone_number') {
                $query->where('phone_number', 'like', '%' . $search . '%');
            }
        }

        // Date range filter
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        // Status filter
        if ($request->filled('status')) {
            $statusId = PostalStatuses::where('status', 'like', $request->status)->first();
            if ($statusId) {
                $query->where('status_id', $statusId->id);
            }
        }

        // Paginate the results
        $records = $query->paginate(10);
        $user = Auth::user();
        $statuses = PostalStatuses::all();
        return view('postalservice.index', compact('records', 'user', 'statuses'));
    }

    /**
     * Display a single postal service record
     */
    public function show($id)
    {
        $record = PostalService::with('status', 'history', 'history.user')->findOrFail($id);
        
        // Check if user is authorized to view (optional: only owner or admin)
        // You can add authorization logic here if needed

        return view('postalservice.show', compact('record'));
    }

    /**
     * Show the form for editing a postal service record
     */
    public function edit($id)
    {
        $record = PostalService::findOrFail($id);
        $statuses = PostalStatuses::all();

        // Check if user is authorized to edit (owner or admin)
        if ($record->user_id !== Auth::id() && Auth::user()->role->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('postalservice.edit', compact('record', 'statuses'));
    }

    /**
     * Update a postal service record in the database
     */
    public function update(Request $request, $id)
    {
        $record = PostalService::findOrFail($id);
        // Check if user is authorized to update (owner or admin)
        if ($record->user_id){
            if ($record->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }
        }

        // Validate the incoming data
        $validated = $request->validate([
            'article_number' => 'nullable|string|max:255',
            'receiver_name' => 'required|string|max:255',
            'receiver_address' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'weight' => 'required|string|max:20',
            'rate' => 'required|integer',
        ]);

        // Update the record
        $record->update($validated);

        return redirect()->route('postalservice.index')->with('success', 'Postal service record updated successfully.');
    }

    /**
     * Update the status of a postal service record and log to PostalHistory
     */
    public function updateStatus(Request $request, $id)
    {
        $record = PostalService::findOrFail($id);

        // Validate the incoming data
        $validated = $request->validate([
            'status_id' => 'required|exists:postalstatuses,id',
        ], [
            'status_id.exists' => 'The selected status is invalid.',
        ]);

        // Check if status is actually changing
        if ($record->status_id == $validated['status_id']) {
            return redirect()->route('postalservice.index')->with('warning', 'No status change made.');
        }

        // Update the record's status
        $record->update(['status_id' => $validated['status_id'], 'user_id' => Auth::id()]);

        // Log the status change to PostalHistory
        \App\Models\PostalHistory::create([
            'postalservice_id' => $id,
            'status_id' => $validated['status_id'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('postalservice.index')->with('success', 'Postal service status updated successfully.');
    }
}
