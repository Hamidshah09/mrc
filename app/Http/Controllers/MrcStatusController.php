<?php

namespace App\Http\Controllers;

use App\Models\MrcStatus;
use Illuminate\Http\Request;

class MrcStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MrcStatus::query();
        // Filters
        if ($request->filled('search')) {
            $query->where('tracking_id', 'like', '%' . $request->search . '%')
                  ->orWhere('applicant_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('certificate_type')) {
            $query->where('certificate_type', $request->certificate_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from')) {
            $query->whereDate('processing_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('processing_date', '<=', $request->to);
        }

        $mrcStatuses = $query->latest()->paginate(10);

        return view('mrc_status.index', compact('mrcStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mrc_status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tracking_id'      => 'required|string|max:50|unique:mrc_status,tracking_id',
            'certificate_type' => 'required|in:Marriage,Divorce',
            'applicant_name'   => 'required|string|max:60',
            'applicant_cnic'   => 'required|string|max:15',
            'processing_date'  => 'required|date',
            'status'           => 'required|in:Certificate Signed,Sent for Verification,Objection',
        ]);

        MrcStatus::create($validated);

        return redirect()->route('mrc_status.index')->with('success', 'Record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MrcStatus $mrcStatus)
    {
        return view('mrc_status.show', compact('mrcStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MrcStatus $mrcStatus)
    {
        return view('mrc_status.edit', compact('mrcStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MrcStatus $mrcStatus)
    {
        $validated = $request->validate([
            'tracking_id'      => 'required|string|max:50|unique:mrc_status,tracking_id,' . $mrcStatus->id,
            'certificate_type' => 'required|in:Marriage,Divorce',
            'applicant_name'   => 'required|string|max:60',
            'applicant_cnic'   => 'required|string|max:15',
            'processing_date'  => 'required|date',
            'status'           => 'required|in:Certificate Signed,Sent for Verification,Objection',
        ]);

        $mrcStatus->update($validated);

        return redirect()->route('mrc_status.index')->with('success', 'Record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MrcStatus $mrcStatus)
    {
        $mrcStatus->delete();

        return redirect()->route('mrc_status.index')->with('success', 'Record deleted successfully.');
    }

    /**
     * Custom: Update only status/remarks from modal.
     */
    public function verify(Request $request, MrcStatus $mrcStatus)
    {
        $validated = $request->validate([
            'status'  => 'required|in:Certificate Signed,Sent for Verification,Objection',
            'remarks' => 'required|string|max:255',
        ]);

        $mrcStatus->update([
            'status'  => $validated['status'],
            // If you want to save remarks, add a column in migration OR handle in logs
        ]);

        return redirect()->route('mrc_status.index')->with('success', 'Status updated successfully.');
    }

    public function update_status(Request $request, MrcStatus $mrcStatus)
    {
        $request->validate([
            'status' => 'required|string|in:Certificate Signed,Sent for Verification,Objection',
        ]);

        $mrcStatus->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'status' => $mrcStatus->status,
        ]);
    }
}
