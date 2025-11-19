<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\idp;
use App\Models\IdpHistory;
use App\Models\IdpUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class IdpController extends Controller
{   public function store_old_id(Request $request){
        $validated = $request->validate([
            'old_id'=>'required',
        ]);
        DB::table('old_idp_ids')->insert([
            'old_id'=>$request->old_id,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Record created successfully',
        ]);
    }
    public function get_old_id(){
        
        $old_id = DB::table('old_idp_ids')->where('status', 'Not Used')->select('old_id')->first();
        if ($old_id){
            DB::table('old_idp_ids')->where('old_id', $old_id->old_id)->update(['status'=>'Reserved']);
                return response()->json([
                    'success' => true,
                    'message' => 'Record found',
                    'data'=> $old_id
                ],200);
        }
        return response()->json([
                'success'=>false,
                'message'=> 'Record Not found',
        ], 401);
    }
    public function update_old_id($old_id){
        DB::table('old_idp_ids')->where('old_id', $old_id)->update(['status'=>'Used']);
        return response()->json([
            'success' => true,
            'message' => 'Record updated successfully',
            'data'=> $old_id
        ]);
    }
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
    public function test_method(Request $request){
        $user = $request->user();
        return response()->json([
            'success' => true,
            'message' => 'Authenticated user retrieved successfully',
            'data' => $user,
        ]);
    }
    public function get_user(Request $request){

        $user_data = IdpUser::where('userid', $request->input('userid'))->first();
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

    public function index(Request $request){
        $query = IdpHistory::orderBy('id', 'desc')->limit(25);
        // Apply search filters
        if ($request->filled('search') && $request->filled('search_type')) {
            $searchType = $request->input('search_type');
            $searchValue = $request->input('search');

            // Sanitize and apply search type filter
            if (in_array($searchType, ['cnic', 'nitb_no', 'first_name'])) {
                $query->where($searchType, 'LIKE', '%' . $searchValue . '%');
            }
        }

        // Date range filter
        if ($request->filled('From')) {
            $query->whereDate('created_at', '>=', $request->input('From'));
        }

        if ($request->filled('To')) {
            $query->whereDate('created_at', '<=', $request->input('To'));
        }

        // Status filter
        // if ($request->filled('status') && in_array($request->input('status'), ['Pending', 'Approved (Certificate Ready)'])) {
        //     $query->where('status', $request->input('status'));
        // }

        // Get filtered results
        $idp = $query->get(); // keep filters in pagination links
        if (!$idp) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found',
            ], 404);
        }

        // ✅ Add full image URL (if exists)

        return response()->json([
            'success' => true,
            'data' => $idp,
        ]);
    }
    public function card_data($id)
    {
        $record = idp::select([
            'id',
            'first_name',
            'last_name',
            'temporary_address',
            'date_of_birth',
            'place_of_birth',
            'driving_license_number',
            'passport_number',
            'app_issue_date',
            'app_expiry_date',
             // include photo path
        ])->find($id);

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found',
            ], 404);
        }

        // ✅ Add full image URL (if exists)
        $record->photo_url = $record->photo
            ? asset('storage/' . $record->photo)
            : null;

        return response()->json([
            'success' => true,
            'data' => $record,
        ]);
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
            'contact' => 'nullable|string|max:20',
            'driving_license_number' => 'nullable|string|max:100',
            'driving_license_issue_date' => 'nullable|date',
            'driving_license_expiry_date' => 'nullable|date',
            'driving_license_vehicle_type_id' => 'nullable|integer',
            'driving_license_issuing_authority' => 'nullable|string|max:255',
            'passport_number' => 'nullable|string|max:50',
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
            'remarks' => 'nullable|string|max:80',
            'status' => 'string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('idp_images', 'public');
            $validated['photo'] = $path;
        }
        $idp = Idp::create($validated);
        $token_no = date('Y'). '-' . date('m'). '-'. $idp->id;
        $idp_no = date('Y').date('m'). $idp->id;
        $idp->idp_no = $idp_no;
        $idp->token_no = $token_no;
        $idp->save();
        return response()->json([
            'success' => true,
            'message' => 'Record created successfully',
            'data' => $idp
        ]);
    }
    public function update(Request $request, $id){
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
            'status' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
            // ✅ Find the record or fail
            $idp = Idp::findOrFail($id);
            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($idp->photo && Storage::disk('public')->exists($idp->photo)) {
                    Storage::disk('public')->delete($idp->photo);
                }

                // Store new photo
                $path = $request->file('photo')->store('idp_images', 'public');
                $validated['photo'] = $path;
            }
            // ✅ Update the record
            $idp->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Record updated successfully',
                'data' => $idp
            ]);


    }
    public function create_password(Request $request, $id){
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
    public function update_password(Request $request)
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
            'first_name' => 'required|string|max:60',
            'last_name' => 'nullable|string|max:60',
            'father_name' => 'nullable|string|max:60',
            'date_of_birth'=>'nullable|date',
            'place_of_birth'=>'string',
            'contact'=>'string|max:15',
            'address'=>'string|max:150',
            'app_issue_date'=>'nullable|date',
            'app_expiry_date'=>'nullable|date',
            'user_id'=>'required|integer',
            'amount'=>'required|integer',
            'passport_no'=>'string|max:50',
            'driving_license_no'=>'required|string|max:50', 
            'driving_license_issue'=>'required|date',
            'driving_license_expiry'=>'required|date',
            'driving_years'=>'integer',
            'application_type'=>'string|max:20',
            'center_id'=>'integer',
        ]);
        $idphis = IdpHistory::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'Record created successfully',
            'data' => $idphis,
        ]);
    }
    public function idp_his_get(Request $request)
    {
        $id = $request->query('id');
        $record = IdpHistory::where('nitb_id', $id)->orderBy('id', 'desc')->first();

        return response()->json([
            'success'=>true,
            'message'=>'Record Retrived',
            'data'=>$record
        ]);
    }
}

