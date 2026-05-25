<?php

namespace App\Http\Controllers\AC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Complaint;
use App\Models\User;
use App\Models\Notification;

use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    /**
     * Dashboard
     */
    public function dashboard()
    {
        $subDivisionId = Auth::user()->sub_division_id;

        $pendingCount = Complaint::where('sub_division_id', $subDivisionId)
            ->where('status', 'pending')
            ->count();

        $assignedCount = Complaint::where('sub_division_id', $subDivisionId)
            ->where('status', 'assigned')
            ->count();

        $resolvedCount = Complaint::where('sub_division_id', $subDivisionId)
            ->where('status', 'resolved')
            ->count();

        $approvedCount = Complaint::where('sub_division_id', $subDivisionId)
            ->where('status', 'approved')
            ->count();

        return view('ac.dashboard', compact(
            'pendingCount',
            'assignedCount',
            'resolvedCount',
            'approvedCount'
        ));
    }

    /**
     * Complaint Listing
     */
    public function index()
    {
        $complaints = Complaint::with([
                'operator',
                'subDivision',
                'policeStation',
                'magistrate'
            ])
            ->where('sub_division_id', Auth::user()->sub_division_id)
            ->latest()
            ->paginate(20);

        return view('ac.complaints.index', compact('complaints'));
    }

    /**
     * Complaint Details
     */
    public function show($id)
    {
        $complaint = Complaint::with([
                'operator',
                'subDivision',
                'policeStation',
                'magistrate'
            ])
            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Security Check
        |--------------------------------------------------------------------------
        */

        if ($complaint->sub_division_id != Auth::user()->sub_division_id) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | Get Magistrates Of Police Station
        |--------------------------------------------------------------------------
        */

        $magistrates = User::where('policestation_id', $complaint->policestation_id)
            ->whereHas('role', function ($q) {
                $q->where('role', 'Magistrate');
            })
            ->get();

        return view('ac.complaints.show', compact(
            'complaint',
            'magistrates'
        ));
    }

    /**
     * Assign Magistrate
     */
    public function assignMagistrate(Request $request, $id)
    {
        $request->validate([
            'magistrate_id' => 'required|exists:users,id',
            'ac_remarks' => 'nullable|max:1000',
        ]);

        $complaint = Complaint::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Security Check
        |--------------------------------------------------------------------------
        */

        if ($complaint->sub_division_id != Auth::user()->sub_division_id) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | Update Complaint
        |--------------------------------------------------------------------------
        */

        $complaint->update([

            'magistrate_id' => $request->magistrate_id,

            'ac_remarks' => $request->ac_remarks,

            'status' => 'assigned',

            'assigned_at' => now(),

        ]);

        /*
        |--------------------------------------------------------------------------
        | Notification
        |--------------------------------------------------------------------------
        */

        Notification::create([

            'user_id' => $request->magistrate_id,

            'complaint_id' => $complaint->id,

            'title' => 'New Complaint Assigned',

            'message' => 'A new complaint has been assigned to you.',

        ]);

        return back()->with(
            'success',
            'Complaint assigned successfully.'
        );
    }

    /**
     * Approve Complaint
     */
    public function approveComplaint(Request $request, $id)
    {
        $request->validate([
            'ac_remarks' => 'nullable|max:1000',
        ]);

        $complaint = Complaint::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Security Check
        |--------------------------------------------------------------------------
        */

        if ($complaint->sub_division_id != Auth::user()->sub_division_id) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | Approve
        |--------------------------------------------------------------------------
        */

        $complaint->update([

            'status' => 'approved',

            'ac_remarks' => $request->ac_remarks,

            'approved_at' => now(),

        ]);

        return back()->with(
            'success',
            'Complaint approved successfully.'
        );
    }

    /**
     * Reject Complaint
     */
    public function rejectComplaint(Request $request, $id)
    {
        $request->validate([
            'ac_remarks' => 'required|max:1000',
        ]);

        $complaint = Complaint::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Security Check
        |--------------------------------------------------------------------------
        */

        if ($complaint->sub_division_id != Auth::user()->sub_division_id) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | Reject
        |--------------------------------------------------------------------------
        */

        $complaint->update([

            'status' => 'rejected',

            'ac_remarks' => $request->ac_remarks,

        ]);

        /*
        |--------------------------------------------------------------------------
        | Notify Magistrate
        |--------------------------------------------------------------------------
        */

        if ($complaint->magistrate_id) {

            Notification::create([

                'user_id' => $complaint->magistrate_id,

                'complaint_id' => $complaint->id,

                'title' => 'Complaint Rejected',

                'message' => 'Please review and resolve again.',

            ]);
        }

        return back()->with(
            'success',
            'Complaint rejected successfully.'
        );
    }
}