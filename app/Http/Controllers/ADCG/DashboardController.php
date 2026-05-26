<?php

namespace App\Http\Controllers\ADCG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Complaint;
use App\Models\PoliceStation;
use App\Models\SubDivision;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Dashboard
     */
    public function dashboard()
    {
        $rejectedCount = Complaint::where('status', 'rejected')->count();

        $assignedCount = Complaint::where('status', 'assigned')->count();

        $resolvedCount = Complaint::where('status', 'resolved')->count();

        $approvedCount = Complaint::where('status', 'approved')->count();

        $disposedCount = Complaint::where('status', 'disposed')->count();

        return view('adcg.dashboard', compact(
            'rejectedCount',
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
        $policeStations = PoliceStation::all();
        $subDivisions = SubDivision::all();
        return view('adcg.complaints.show', compact('complaint', 'policeStations', 'subDivisions'));
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

    public function reassign(Request $request, $id)
    {
        $request->validate([

            'sub_division_id' => 'required|exists:sub_divisions,id',

            'policestation_id' => 'required|exists:policestations,id',

            'admin_remarks' => 'nullable|max:1000',
        ]);

        $complaint = Complaint::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Find New AC
        |--------------------------------------------------------------------------
        */
        
        $ac = User::where('sub_division_id', $request->sub_division_id)
            ->where('status', 'Active')
            ->whereHas('role', function ($q) {

                $q->where('role', 'AC');

            })

            ->first();
        /*
        |--------------------------------------------------------------------------
        | Find Active Magistrate
        |--------------------------------------------------------------------------
        */

        $magistrate = User::where('policestation_id', $request->policestation_id)

            ->where('status', 'Active')

            ->whereHas('role', function ($q) {

                $q->where('role', 'Magistrate');

            })

            ->first();

        /*
        |--------------------------------------------------------------------------
        | Update Complaint
        |--------------------------------------------------------------------------
        */

        $complaint->update([

            'sub_division_id' => $request->sub_division_id,

            'policestation_id' => $request->policestation_id,

            'ac_id' => $ac?->id,

            'magistrate_id' => $magistrate?->id,

            'admin_remarks' => $request->admin_remarks,

            'status' => 'assigned',
        ]);

        return back()->with(
            'success',
            'Complaint reassigned successfully.'
        );
    }
}