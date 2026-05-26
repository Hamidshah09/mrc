<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Complaint;
use App\Models\SubDivision;
use App\Models\PoliceStation;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Complaint Listing
     */
    public function index()
    {
        $complaints = Complaint::with('magistrate')->where('operator_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('operator.complaints.index', compact('complaints'));
    }

    /**
     * Create Form
     */
    public function create()
    {
        $subDivisions = SubDivision::orderBy('name')->get();

        return view('operator.complaints.create', compact('subDivisions'));
    }

    /**
     * Store Complaint
     */
    public function store(Request $request)
    {
        $request->validate([

            'sub_division_id' => 'required|exists:sub_divisions,id',

            'policestation_id' => 'required|exists:policestations,id',

            'before_image' => 'required|image|mimes:jpg,jpeg,png|max:8096',

            'latitude' => 'nullable',

            'longitude' => 'nullable',

            'google_map_link' => 'nullable',

            'operator_remarks' => 'nullable|max:1000',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload Image
        |--------------------------------------------------------------------------
        */

        $imageName = null;

        if ($request->hasFile('before_image')) {

            $imageName = time() . '_' . uniqid() . '.' .
                $request->before_image->extension();

            $request->before_image->storeAs(
                'complaints',
                $imageName,
                'public'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Get AC Automatically From Subdivision
        |--------------------------------------------------------------------------
        */

        $ac = \App\Models\User::where('sub_division_id', $request->sub_division_id)
            ->whereHas('role', function ($q) {
                $q->where('role', 'AC');
            })
            ->first();
        $magistrate = \App\Models\User::where('policestation_id', $request->policestation_id)

            ->where('status', 'Active')

            ->whereHas('role', function ($q) {

                $q->where('role', 'Magistrate');

            })

            ->first();
        /*
        |--------------------------------------------------------------------------
        | Create Complaint
        |--------------------------------------------------------------------------
        */

        Complaint::create([

            'operator_id' => Auth::id(),

            'ac_id' => $ac?->id,
            
            'magistrate_id' => $magistrate?->id,

            'sub_division_id' => $request->sub_division_id,

            'policestation_id' => $request->policestation_id,

            'before_image' => $imageName,

            'latitude' => $request->latitude,

            'longitude' => $request->longitude,

            'google_map_link' => $request->google_map_link,

            'operator_remarks' => $request->operator_remarks,

            'status' => 'assigned',
        ]);

        return redirect()
            ->route('operator.complaints.index')
            ->with('success', 'Complaint submitted successfully.');
    }

    /**
     * Get Police Stations By Subdivision
     */
    public function getPoliceStations($subDivisionId)
    {
        $policeStations = PoliceStation::where('sub_division_id', $subDivisionId)
            ->orderBy('name')
            ->get();

        return response()->json($policeStations);
    }
}