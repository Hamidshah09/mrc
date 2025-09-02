<?php

namespace App\Http\Controllers;

use App\Models\districts;
use App\Models\idp;
use App\Models\tehsils;
use Illuminate\Http\Request;

class idpController extends Controller
{
    public function create(){
        $districts = districts::all();
        $tehsils = tehsils::all();
        return view('idp.create', compact('districts','tehsils'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'gender_id' => 'nullable|integer',
            'date_of_birth' => 'nullable|date',
            'cnic' => 'nullable|string|max:20',
            'place_of_birth' => 'nullable|string|max:255',
            'qualification_id' => 'nullable|integer',
            'occupation_id' => 'nullable|integer',
            'temporary_address_province_id' => 'nullable|integer',
            'temporary_address_district_id' => 'nullable|integer',
            'temporary_address_tehsil_id' => 'nullable|integer',
            'temporary_address' => 'nullable|string|max:500',
            'permanent_address_province_id' => 'nullable|integer',
            'permanent_address_district_id' => 'nullable|integer',
            'permanent_address_tehsil_id' => 'nullable|integer',
            'permanent_address' => 'nullable|string|max:500',
            'contact' => 'nullable|string|max:20',
            'driving_license_number' => 'nullable|string|max:100',
            'driving_license_issue_date' => 'nullable|date',
            'driving_license_expiry_date' => 'nullable|date',
            'driving_license_vehicle_type_id' => 'nullable|integer',
            'driving_license_issuing_authority' => 'nullable|string|max:255',
            'passport_number' => 'nullable|string|max:100',
            'passport_issue_date' => 'nullable|date',
            'passport_expiry_date' => 'nullable|date',
            'passport_type_id' => 'nullable|integer',
            'applicant_type_id' => 'nullable|integer',
            'request_type_id' => 'nullable|integer',
            'service_type_id' => 'nullable|integer',
            'payment_type_id' => 'nullable|integer',
            'application_type' => 'nullable|integer',
            'app_issue_date' => 'nullable|date',
            'driving_years' => 'nullable|integer',
            'app_expiry_date' => 'nullable|date',
            'amount' => 'nullable|numeric',
            'remarks' => 'nullable|string|max:255',
        ]);

        $idp = idp::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Record created successfully',
            'data' => $idp
        ]);
    }
    public function edit($id, $cnic){

    }
    public function update($id){

    }
}
