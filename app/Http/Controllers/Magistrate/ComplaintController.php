<?php

namespace App\Http\Controllers\Magistrate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Complaint;
use App\Models\Notification;

use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    /**
     * Dashboard
     */
    public function dashboard()
    {
        $pendingCount = Complaint::where('magistrate_id', Auth::id())
            ->where('status', 'assigned')
            ->count();

        $resolvedCount = Complaint::where('magistrate_id', Auth::id())
            ->where('status', 'resolved')
            ->count();

        $approvedCount = Complaint::where('magistrate_id', Auth::id())
            ->where('status', 'approved')
            ->count();

        $rejectedCount = Complaint::where('magistrate_id', Auth::id())
            ->where('status', 'rejected')
            ->count();

        return view('magistrate.dashboard', compact(
            'pendingCount',
            'resolvedCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    /**
     * Complaint Listing
     */
    public function index(Request $request)
    {
        $query = Complaint::with([
                'operator',
                'subDivision',
                'policeStation'
            ])
            ->where('magistrate_id', Auth::id());

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Police Station Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('policestation_id')) {

            $query->where(
                'policestation_id',
                $request->policestation_id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Latest First
        |--------------------------------------------------------------------------
        */

        $complaints = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Police Stations Dropdown
        |--------------------------------------------------------------------------
        */

        $policeStations = Complaint::where(
                'magistrate_id',
                Auth::id()
            )
            ->with('policeStation')
            ->get()
            ->pluck('policeStation')
            ->unique('id')
            ->filter()
            ->sortBy('name');

        return view(
            'magistrate.complaints.index',
            compact(
                'complaints',
                'policeStations'
            )
        );
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
                'ac'
            ])
            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Security Check
        |--------------------------------------------------------------------------
        */

        if ($complaint->magistrate_id != Auth::id()) {

            abort(403);

        }

        return view('magistrate.complaints.show', compact('complaint'));
    }

    /**
     * Resolve Complaint
     */
    public function resolveComplaint(Request $request, $id)
    {
        $request->validate([

            'after_image' => 'required|image|mimes:jpg,jpeg,png|max:8096',

            'magistrate_remarks' => 'nullable|max:1000',

        ]);

        $complaint = Complaint::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Security Check
        |--------------------------------------------------------------------------
        */

        if ($complaint->magistrate_id != Auth::id()) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | Upload Resolution Image
        |--------------------------------------------------------------------------
        */

        $imageName = null;

        if ($request->hasFile('after_image')) {

            $imageName = time() . '_' . uniqid() . '.' .
                $request->after_image->extension();

            $request->after_image->storeAs(
                'complaints',
                $imageName,
                'public'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Update Complaint
        |--------------------------------------------------------------------------
        */

        $complaint->update([

            'after_image' => $imageName,

            'magistrate_remarks' => $request->magistrate_remarks,

            'status' => 'resolved',

            'resolved_at' => now(),

        ]);

        /*
        |--------------------------------------------------------------------------
        | Notify AC
        |--------------------------------------------------------------------------
        */

        if ($complaint->ac_id) {

            Notification::create([

                'user_id' => $complaint->ac_id,

                'complaint_id' => $complaint->id,

                'title' => 'Complaint Resolved',

                'message' => 'A complaint has been resolved and requires approval.',

            ]);
        }

        return redirect()
            ->route('magistrate.complaints.index')
            ->with(
                'success',
                'Complaint resolved successfully.'
            );
    }
}