<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;
use App\Models\tehsils;
use App\Models\districts;
use App\Models\DomicileApplicants;
use App\Models\children;
use App\Models\NocOtherDistrict;
use App\Models\NocOtherDistrictApplicants;
use App\Models\NocICT;
use App\Models\NocICTApplicants;
use App\Models\DomicileCancellation;
use App\Models\DispatchDiary;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PublicRequestsController extends Controller
{
    public function index()
    {
        return view('public.index');
    }
    public function create_domicile(){
        $tehsils = tehsils::orderBy('name')->get();
        $districts = districts::orderBy('name')->get();
        return view('public.create-domicile',  compact('tehsils', 'districts'));
    }
    public function store_domicile(Request $request)
    {   
        
    $validated = $request->validate([
        'cnic' => ['required', 'regex:/^[0-9]{13}$/', Rule::unique('remote_mysql.domicile','cnic')],
        'name' => 'required|string|max:45',
        'father_name' => 'required|string|max:45',
        'spouse_name' => 'nullable|string|max:45',
        'date_of_birth' => 'required|date',
        'gender_id' => 'required|integer',
        'place_of_birth' => 'required|string|max:45',
        'marital_status_id' => 'required|integer',
        'religion' => 'required|string|max:45',
        'qualification_id' => 'nullable|integer',
        'occupation_id' => 'nullable|integer',
        'contact' => 'nullable|string|max:11',
        'arrival_date' => 'required|date',

        // Temporary Address
        'present_province_id' => 'required|integer',
        'present_district_id' => 'required|integer',
        'present_tehsil_id' => 'required|integer',
        'present_address' => 'required|string|max:100',

        // Permanent Address
        'permanent_province_id' => 'required|integer',
        'permanent_district_id' => 'required|integer',
        'permanent_tehsil_id' => 'required|integer',
        'permanent_address' => 'required|string|max:100',

        'children_checkbox' => 'nullable|boolean',
    ]);

    $request->validate([
    'children.*.cnic' => 'required|regex:/^[0-9]{13}$/',
    'children.*.name' => 'required|string|max:45',
    'children.*.dob' => 'required|date',
    'children.*.gender_id' => 'required|in:1,2',
    ]);

    $domicile = new DomicileApplicants();

    // Personal Info
    $domicile->cnic = strtoupper($validated['cnic']);
    $domicile->first_name = strtoupper($validated['name']);
    $domicile->father_name = strtoupper($validated['father_name']);
    $domicile->spouse_name = $validated['spouse_name'] ? strtoupper($validated['spouse_name']) : null; // nullable
    $domicile->date_of_birth = $validated['date_of_birth'];
    $domicile->gender_id = $validated['gender_id'];
    $domicile->place_of_birth = $validated['place_of_birth'];
    $domicile->marital_status_id = $validated['marital_status_id'];
    $domicile->religion = strtoupper($validated['religion']);
    $domicile->qualification_id = $request->input('qualification_id'); // nullable
    $domicile->occupation_id = $request->input('occupation_id'); // nullable
    $domicile->contact = $request->input('contact');
    $domicile->arrival_date = $request->input('arrival_date');

    // Temporary Address
    $domicile->present_province_id = $validated['present_province_id'];
    $domicile->present_district_id = $validated['present_district_id'];
    $domicile->present_tehsil_id = $validated['present_tehsil_id'];
    $domicile->present_address = strtoupper($validated['present_address']);

    // Permanent Address
    $domicile->permanent_province_id = $validated['permanent_province_id'];
    $domicile->permanent_district_id = $validated['permanent_district_id'];
    $domicile->permanent_tehsil_id = $validated['permanent_tehsil_id'];
    $domicile->permanent_address = strtoupper($validated['permanent_address']);

    $domicile->application_type_id = 1; // assuming 1 is for public applications
    $domicile->service_type_id = 1; // assuming 1 is for domicile service
    $domicile->payment_type_id = 1; // assuming 1 is for cash payment
    $domicile->request_type_id = 1; // assuming 1 is for new application
    $domicile->status = 'Pending';
    $domicile->priority_type = 'Normal';
    
    // Children Checkbox
    // $domicile->has_children = $request->has('children_checkbox') ? true : false;

    $domicile->save();
    
    $children = $request->input('children');
    if ($children){
        foreach ($children as $child) {
            // Save each child
            children::create([
                'applicant_id'=>$domicile->id,
                'cnic' => $child['cnic'],
                'child_name' => $child['name'],
                'date_of_birth' => $child['dob'],
                'gender_id' => $child['gender_id'],
                // Add any foreign keys, like user_id, etc.
            ]);
        }
    }
    
    
    $other_district_found=0;
    //Checking in other districts
    
    $cnic = $domicile->cnic;
    try {
        
        if ($cnic) {

            $apiUrl = "http://127.0.0.1:8000/domicile/check-in-other-district/{$cnic}";

            $response = Http::timeout(60)->get($apiUrl);

            if ($response->successful()) {

                $apiData = $response->json();

                if (
                    isset($apiData['found']) &&
                    $apiData['found'] === true
                ) {

                    $other_district_found = 1;
                }
            }
        }

    } catch (\Exception $e) {

        Log::error('NITB API Error', [
            'cnic' => $cnic ?? null,
            'message' => $e->getMessage()
        ]);
    }
    $domicile->other_district_status = $other_district_found;
    $domicile->save();

    //checking in nitb

    try {

        $nitb_found = null; // default = not checked

        if ($cnic) {

            $apiUrl = "http://127.0.0.1:8000/domicile/check-in-nitb/{$cnic}";

            $response = Http::timeout(60)->get($apiUrl);

            if ($response->successful()) {

                $apiData = $response->json();

                $nitb_found =
                    ($apiData['status'] ?? null) === 'success'
                    && ($apiData['records'] ?? 0) > 0
                        ? 1
                        : 0;
            }
        }

    } catch (\Exception $e) {

        Log::error('NITB API Error', [
            'cnic' => $cnic ?? null,
            'message' => $e->getMessage()
        ]);

        $nitb_found = null;
    }

    $domicile->nitb_status = $nitb_found;
    $domicile->save();


    //checking in other district letter

    $noc_ohter_status = NocOtherDistrictApplicants::where('CNIC', $cnic)->get();
    if ($noc_ohter_status){
        $domicile->noc_other_district_letter = 1;
    }else{
        $domicile->noc_other_district_letter = 0;
    }
    
    //checking in noc ict letter

    $noc_ict_status = NocICTApplicants::where('CNIC', $cnic)->get();
    if ($noc_ict_status){
        $domicile->noc_ict_letter = 1;
    }else{
        $domicile->noc_ict_letter = 0;
    }

    //checking in cancellation
    $cancellation_status= DomicileCancellation::where('CNIC', $cnic)->get();
    if ($cancellation_status){
        $domicile->cancellation_letter = 1;
    }else{
        $domicile->cancellation_letter = 0;
    }
    
    $domicile->save();

    return view('public.success', [
            'id'   => $domicile->id,
            'recordType' => 'Domicile Application'
        ]);
    }

    public function create_noc()
    {
        return view('public.create-noc');
    }

    public function show_noc(Request $request)
    {
        $id = $request->query('id');
        $cnic = $request->query('cnic');

    // Start building the base query
        $query = NocLetters::with(['nocapplicants' => function ($q) use ($cnic) {
            if ($cnic) {
                $q->where('cnic', $cnic);
            }
        }]);

        if ($id) {
            $noc_record = $query->find($id);

            if (!$noc_record) {
                return response()->json([
                    'success' => false,
                    'message' => 'NOC record not found.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $noc_record
            ], 200);
        }

        // If no ID is provided but CNIC is
        if ($cnic) {
            $noc_records = $query
                ->whereHas('nocapplicants', function ($q) use ($cnic) {
                    $q->where('cnic', 'like', '%'.$cnic.'%');
                })->get();

            if ($noc_records->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No records found for the provided CNIC.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $noc_records
            ]);
        }

        // If neither ID nor CNIC is provided
        $noc_records = NocLetters::with('nocapplicants')
        ->orderBy('id', 'desc') // or 'created_at' if you prefer timestamp
        ->take(200)
        ->get();

        return response()->json([
                'success' => true,
                'data' => $noc_records
            ]);
    }

    public function store_noc(Request $request)
    {
        
        $validated = $request->validate([
            'referenced_letter_no' => 'nullable|string|max:255',
            'referenced_letter_date' => 'nullable|date',
            'letter_type' => 'required|max:10',
            'Letter_Date' => 'required|date',
            'NOC_Issued_To' => 'required|string|max:60',
            'Remarks' => 'nullable|string|max:500',
            'applicants' => 'nullable|array',
            'applicants.*.CNIC' => 'required|digits:13',
            'applicants.*.Applicant_Name' => 'nullable|string|max:255',
            'applicants.*.Relation' => 'nullable|string|max:50',
            'applicants.*.Applicant_FName' => 'nullable|string|max:255',
        ]);

        $letter = NocOtherDistrict::create([
            'Letter_Date' => $validated['Letter_Date'] ?? null,
            'letter_type' => $validated['letter_type'] ?? 'self',
            'NOC_Issued_To' => $validated['NOC_Issued_To'] ?? null,
            'referenced_letter_no' => $validated['referenced_letter_no'] ?? null,
            'referenced_letter_date' => $validated['referenced_letter_date'] ?? null,
            'Remarks' => $validated['Remarks'] ?? null,
        ]);
        $letterId = $letter->Letter_ID;
        $nitbFound = 0;
        //inserting dispatch diary record
        $lastDispatch = DispatchDiary::latest('Dispatch_ID')->first();

        $currentYear = now()->year;

        if (!$lastDispatch || $lastDispatch->timestamp->year != $currentYear) {
            $dispatchNo = 1;
        } else {
            $dispatchNo = $lastDispatch->Dispatch_No + 1;
        }

        DispatchDiary::create([
            'Dispatch_No' => $dispatchNo,
            'Letter_Type' => 'NOC Letter',
            'Letter_ID' => $letterId,
        ]);
        $applicants = $request->input('applicants', []);
        if (is_array($applicants) && count($applicants) > 0) {
            foreach ($applicants as $app) {
                // skip completely empty rows
                if (empty(array_filter($app))) {
                    continue;
                }

                //Checking in NITB
                 try {

                    $cnic = $app['CNIC'] ?? null;

                    if ($cnic) {

                        $apiUrl = "https://cfc-ict.com/fastapi/domicile/check-in-nitb/{$cnic}";

                        $response = Http::timeout(60)->get($apiUrl);

                        if ($response->successful()) {
                            $apiData = $response->json();

                            if (
                                isset($apiData['records']) &&
                                $apiData['records'] > 0
                            ) {

                                $nitbFound = 1;
                            }
                        }
                    }

                } catch (\Exception $e) {

                    Log::error('NITB API Error', [
                        'cnic' => $cnic ?? null,
                        'message' => $e->getMessage()
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Save Applicant
                |--------------------------------------------------------------------------
                */
                NocOtherDistrictApplicants::create([
                    'Letter_ID' => $letterId,
                    'Applicant_Name' => $app['Applicant_Name'] ?? null,
                    'CNIC' => $app['CNIC'] ?? null,
                    'Relation' => $app['Relation'] ?? null,
                    'Applicant_FName' => $app['Applicant_FName'] ?? null,
                ]);
            }

            $letter->update([
                'nitb_status' => $nitbFound
            ]);
        }

    return view('public.success', [
            'id'   => $letter->Letter_ID,
            'recordType' => 'NOC to Other District Application'
        ]);    
    }

    public function create_noc_ict(){
        return view('public.create-noc-ict');
    }
    public function store_noc_ict(Request $request){
        $validated = $request->validate([
            'letter.Letter_Date' => 'nullable|date',
            'letter.Letter_Sent_to' => 'required|string|max:255',
            'letter.Remarks' => 'nullable|string|max:500',
            'applicants' => 'nullable|array',
            'applicants.*.CNIC' => 'required|string|max:13',
            'applicants.*.Applicant_Name' => 'nullable|string|max:255',
            'applicants.*.Relation' => 'nullable|string|max:50',
            'applicants.*.Applicant_FName' => 'nullable|string|max:255',
        ]);

        $letterInput = $request->input('letter', []);

        $letter = NocICT::create([
            'letter_date' => $letterInput['Letter_Date'] ?? null,
            'letter_sent_to' => $letterInput['Letter_Sent_to'] ?? null,
        ]);
        $letterId = $letter->Letter_ID;
        $nitbFound = 0;
        //inserting dispatch diary record
        $lastDispatch = DispatchDiary::latest('Dispatch_ID')->first();

        $currentYear = now()->year;

        if (!$lastDispatch || $lastDispatch->timestamp->year != $currentYear) {
            $dispatchNo = 1;
        } else {
            $dispatchNo = $lastDispatch->Dispatch_No + 1;
        }

        DispatchDiary::create([
            'Dispatch_No' => $dispatchNo,
            'Letter_Type' => 'NOC ICT Letter',
            'Letter_ID' => $letterId,
        ]);
        $applicants = $request->input('applicants', []);
        if (is_array($applicants) && count($applicants) > 0) {
            foreach ($applicants as $app) {
                // skip completely empty rows
                if (empty(array_filter($app))) {
                    continue;
                }

                //Checking in other districts
                 try {

                    $cnic = $app['CNIC'] ?? null;

                    if ($cnic) {

                        $apiUrl = "https://cfc-ict.com/fastapi/domicile/check-in-other-district/{$cnic}";

                        $response = Http::timeout(60)->get($apiUrl);

                        if ($response->successful()) {

                            $apiData = $response->json();

                            Log::info('NITB API Response', [
                                'cnic' => $cnic,
                                'response' => $apiData
                            ]);

                            if (
                                isset($apiData['found']) &&
                                $apiData['found'] === true
                            ) {

                                $nitbFound = 1;
                            }
                        }
                    }

                } catch (\Exception $e) {

                    Log::error('NITB API Error', [
                        'cnic' => $cnic ?? null,
                        'message' => $e->getMessage()
                    ]);
                }

                NocICTApplicants::create([
                    'Letter_ID' => $letterId,
                    'Applicant_Name' => $app['Applicant_Name'] ?? null,
                    'CNIC' => $app['CNIC'] ?? null,
                    'Relation' => $app['Relation'] ?? null,
                    'Applicant_FName' => $app['Applicant_FName'] ?? null,
                ]);
            }
            $letter->update([
                'other_district_status' => $nitbFound
            ]);
        }

        return view('public.success', [
            'id'   => $letter->Letter_ID,
            'recordType' => 'NOC for ICT Application'
        ]);
    }


}
