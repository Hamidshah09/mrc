<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Complaint;
use App\Models\SubDivision;
use App\Models\PoliceStation;

class ComplaintController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Complaint Listing
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $complaints = Complaint::where(
                'operator_id',
                $request->user()->id
            )
            ->latest()
            ->get();

        return response()->json($complaints);
    }

    /*
    |--------------------------------------------------------------------------
    | Sub Divisions
    |--------------------------------------------------------------------------
    */

    public function subDivisions()
    {
        return response()->json(
            SubDivision::orderBy('name')->get()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Police Stations
    |--------------------------------------------------------------------------
    */

    public function policeStations($id)
    {
        return response()->json(

            PoliceStation::where(
                'sub_division_id',
                $id
            )->orderBy('name')->get()

        );
    }

    /*
    |--------------------------------------------------------------------------
    | Store Complaint
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'sub_division_id' => 'required',

            'policestation_id' => 'required',

            'remarks' => 'nullable',

            'google_map_link' => 'required',

            'before_image' => 'required|image|max:4096',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload Image
        |--------------------------------------------------------------------------
        */

        $imageName = time() . '.' .
            $request->before_image->extension();

        $request->before_image->storeAs(
            'complaints',
            $imageName,
            'public'
        );

        /*
        |--------------------------------------------------------------------------
        | Create Complaint
        |--------------------------------------------------------------------------
        */

        $complaint = Complaint::create([

            'operator_id' => $request->user()->id,

            'sub_division_id' => $request->sub_division_id,

            'policestation_id' => $request->policestation_id,

            'before_image' => $imageName,

            'google_map_link' => $request->google_map_link,

            'operator_remarks' => $request->remarks,

            'status' => 'pending',
        ]);

        return response()->json([

            'success' => true,

            'message' => 'Complaint submitted successfully.',

            'data' => $complaint

        ]);
    }
}