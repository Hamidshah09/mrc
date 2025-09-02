<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Idp;
use App\Models\IdpHistory;
use App\Models\IdpUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class IdpController extends Controller
    {   
    public function store_nitbuser(Request $request){
    $validated = $request->validate([
        'userid'=>'required|string',
        'code'=>'required|string',
    ]);
    IdpUser::create($validated);
    return response()->json([
            'success' => true,
            'message' => 'Record created successfully',
        ]);
    }
    public function get_nitbuser($id){
        $user_data = IdpUser::where('userid', $id)->first();
        if ($user_data){
            return response()->json([
                            'success' => true,
                            'user_data' => $user_data,
                            ]);
        }else{
            return response()->json([
                            'success' => false,
                            'user_data' => null,
                            ]);

        }
    }
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'nitb_id' => 'required|integer',
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

        $idp = Idp::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Record created successfully',
            'data' => $idp
        ]);
    }
    public function update_password(Request $request, $id){
        $validated = $request->validate([
            'password'=>'required|string',
        ]);
        $user = User::findOrFail($id);

        $user->password = $validated['password'];
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'Password Updated successfully',
        ]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'current_password'      => 'required',
            'new_password'          => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'The current password is incorrect.'
            ], 422);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'message' => 'Password updated successfully.'
        ]);
    }
    public function idp_his_store(Request $request){
        $validated = $request->validate([
            'nitb_id' => 'required|integer',
            'cnic'=>'required|string|min:13|max:13',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'user_id'=>'required|integer'
        ]);
        $idphis = IdpHistory::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'Record created successfully',
            'data' => $idphis,
        ]);
    }
}

