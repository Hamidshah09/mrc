<?php

namespace App\Http\Controllers\ADCG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Complaint;

class DashboardController extends Controller
{
    /**
     * Dashboard
     */
    public function dashboard()
    {
        $pendingCount = Complaint::where('status', 'pending')->count();

        $assignedCount = Complaint::where('status', 'assigned')->count();

        $resolvedCount = Complaint::where('status', 'resolved')->count();

        $approvedCount = Complaint::where('status', 'approved')->count();

        $disposedCount = Complaint::where('status', 'disposed')->count();

        return view('adcg.dashboard', compact(
            'pendingCount',
            'assignedCount',
            'resolvedCount',
            'approvedCount',
            'disposedCount'
        ));
    }

    /**
     * Complaints Listing
     */
    public function complaints()
    {
        $complaints = Complaint::with([
                'operator',
                'subDivision',
                'policeStation',
                'magistrate',
                'ac'
            ])
            ->latest()
            ->paginate(20);

        return view('adcg.complaints.index', compact('complaints'));
    }

    /**
     * Complaint Detail
     */
    public function show($id)
    {
        $complaint = Complaint::with([
                'operator',
                'subDivision',
                'policeStation',
                'magistrate',
                'ac'
            ])
            ->findOrFail($id);

        return view('adcg.complaints.show', compact('complaint'));
    }

    /**
     * Dispose Complaint
     */
    public function dispose(Request $request, $id)
    {
        $request->validate([
            'admin_remarks' => 'nullable|max:1000',
        ]);

        $complaint = Complaint::findOrFail($id);

        $complaint->update([
            'status' => 'disposed',
            'admin_remarks' => $request->admin_remarks,
            'disposed_at' => now(),
        ]);

        return back()->with(
            'success',
            'Complaint disposed successfully.'
        );
    }
}