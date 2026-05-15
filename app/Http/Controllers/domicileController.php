<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\children;
use App\Models\districts;
use App\Models\DomicileApplicants;
use App\Models\DomicileStatus;
use App\Models\NocApplicants;
use App\Models\NocLetters;
use App\Models\NocICT;
use App\Models\NocICTApplicants;
use App\Models\NocOtherDistrictApplicants;
use App\Models\OnlineApplication;
use App\Models\tehsils;
use App\Models\DispatchDiary;
use App\Models\BlackListDomicileApplications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class domicileController extends Controller
{   

    public $provinces;
    public $qualifications;
    public $occupations;
    public $maritalStatuses;
    public $genders;
    public $applications;
    public $request_types;
    public $service_types;
    public $payment_types;

    public function __construct()
    {
        $this->provinces = collect([
            (object)['ID'=>491, 'Province'=>'Balochistan'],
            (object)['ID'=>663, 'Province'=>'Federal Capital'],
            (object)['ID'=>1, 'Province'=>'Khyber Pakhtunkhwa'],
            (object)['ID'=>167, 'Province'=>'Punjab'],
            (object)['ID'=>344, 'Province'=>'Sindh'],
        ]);

        $this->qualifications = collect([
            (object)['id' => 1, 'name' => 'Primary'],
            (object)['id' => 2, 'name' => 'Middle'],
            (object)['id' => 3, 'name' => 'SSC'],
            (object)['id' => 4, 'name' => 'HSSC'],
            (object)['id' => 5, 'name' => 'Bachelors'],
            (object)['id' => 6, 'name' => 'Masters'],
            (object)['id' => 7, 'name' => 'PhD'],
            (object)['id' => 8, 'name' => 'Not Available'],
            (object)['id' => 9, 'name' => 'Other'],
            (object)['id' => 10, 'name' => 'Islamic Education'],
        ]);

        $this->occupations = collect([
            (object)['id' => 1, 'name' => 'Government Employee'],
            (object)['id' => 2, 'name' => 'Non Government Employee'],
            (object)['id' => 3, 'name' => 'Own Business'],
            (object)['id' => 4, 'name' => 'Student'],
            (object)['id' => 5, 'name' => 'Other'],
            (object)['id' => 6, 'name' => 'House wife'],
            (object)['id' => 7, 'name' => 'Private Job'],
        ]);

        $this->maritalStatuses = collect([
            (object)['id' => 1, 'name' => 'Single'],
            (object)['id' => 2, 'name' => 'Married'],
            (object)['id' => 3, 'name' => 'Divorced'],
            (object)['id' => 4, 'name' => 'Widowed'],
            (object)['id' => 5, 'name' => 'Widower'],
        ]);

        $this->genders = collect([
            (object)['id' => 1, 'name' => 'Male'],
            (object)['id' => 2, 'name' => 'Female'],
            (object)['id' => 3, 'name' => 'Transgender'],
        ]);

        $this->request_types = collect([
            (object)['id' => 1, 'name' => 'New'],
            (object)['id' => 2, 'name' => 'Duplicate'],
            (object)['id' => 3, 'name' => 'Revised'],
        ]);

        $this->service_types = collect([
            (object)['id' => 1, 'name' => 'Online'],
            (object)['id' => 2, 'name' => 'Offline'],
        ]);

        $this->payment_types = collect([
            (object)['id' => 1, 'name' => 'Cash'],
            (object)['id' => 2, 'name' => 'Challan'],
            (object)['id' => 3, 'name' => 'Esahulat'],
            (object)['id' => 4, 'name' => '1 Link'],
        ]);
    }
    

    public function index(Request $request){
        $query = DomicileApplicants::select('id', 'first_name', 'cnic', 'contact',  'other_district_status','created_at',
                                            'nitb_status', 'noc_other_district_letter', 'noc_ict_letter', 'cancellation_letter', 'blacklist_status')->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function($wr) use ($q) {
                $wr->where('first_name', 'like', "%{$q}%")
                   ->orWhere('cnic', 'like', "%{$q}%")
                   ->orWhere('id', $q);
            });
        }


        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $records = $query->paginate(25)->appends($request->query());

        return view('domicile.index', compact('records'));
    
    }

    public function create(){
        $tehsils = tehsils::orderBy('name')->get();
        $districts = districts::orderBy('name')->get();
        $provinces = $this->provinces;
        $qualifications = $this->qualifications;
        $occupations = $this->occupations;
        $maritalStatuses = $this->maritalStatuses;
        $genders= $this->genders;
        $request_types = $this->request_types;
        $service_types = $this->service_types;
        $payment_types = $this->payment_types;
        $approvers = DB::connection('remote_mysql')->table('approvers')->get();

        return view('domicile.create', compact('tehsils', 'districts', 'provinces', 'maritalStatuses','qualifications','occupations','genders','request_types','service_types','payment_types','approvers'));
    }
    public function store(Request $request)
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

        // Service Details
        'application_type_id' => 'nullable|integer',
        'request_type_id' => 'nullable|integer',
        'service_type_id' => 'nullable|integer',
        'payment_type_id' => 'nullable|integer',
        'purpose' => 'nullable|string|max:45',
        'priority_type' => 'nullable|string|max:10',
        'receipt_no' => 'nullable|string|max:100',
        'remarks'=>'nullable|string|max:80',
        'approver_id' => 'nullable|integer',

        'children_checkbox' => 'nullable|string',
    ]);

    $request->validate([
    'children.*.cnic' => 'required|regex:/^[0-9]{13}$/',
    'children.*.name' => 'required|string|max:45',
    'children.*.dob' => 'required|date',
    'children.*.gender_id' => 'required|in:1,2',
    ]);

    $domicile = new DomicileApplicants();

    // Personal Info
    $domicile->status = 'Pending';
    $domicile->cnic = strtoupper($validated['cnic']);
    $domicile->first_name = strtoupper($validated['name']);
    $domicile->father_name = strtoupper($validated['father_name']);
    $domicile->spouse_name = strtoupper($validated['spouse_name']); // nullable
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

    $domicile->application_type_id = $validated['application_type_id'] ?? 1; // default to manual application
    $domicile->request_type_id = $validated['request_type_id'] ?? 1; // default to new domicile request
    $domicile->service_type_id = $validated['service_type_id'] ?? 1; // default to offline service
    $domicile->payment_type_id = $validated['payment_type_id'] ?? 1; // default to cash payment
    $domicile->priority_type = "Normal"; // default to normal priority
    $domicile->purpose  = $validated['purpose'] ?? 'N/A'; // optional purpose field
    $domicile->user_id = auth()->id(); // assuming user must be logged in to create record  
    $domicile->receipt_no = $validated['receipt_no'] ?? null; // optional receipt number
    $domicile->approver_id = $validated['approver_id'] ?? null; // optional approver
    $domicile->remarks = $validated['remarks'];

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
                'name' => $child['name'],
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
    
    $blacklist_status= BlackListDomicileApplications::where('CNIC', $cnic)->get();
    if ($blacklist_status){
        $domicile->blacklist_status = 1;
    }else{
        $domicile->blacklist_status = 0;
    }
    $domicile->save();
    return redirect()->route('domicile.index')->with('success', 'Domicile record created successfully.');
    }

    public function edit($id){

        $tehsils = tehsils::orderBy('name')->get();
        $districts = districts::orderBy('name')->get();
        $provinces = $this->provinces;
        $qualifications = $this->qualifications;
        $occupations = $this->occupations;
        $maritalStatuses = $this->maritalStatuses;
        $genders= $this->genders;
        $request_types = $this->request_types;
        $service_types = $this->service_types;
        $payment_types = $this->payment_types;
        $approvers = DB::connection('remote_mysql')->table('approvers')->get();

        
        $applicant = DomicileApplicants::with('children')->findOrFail($id);
        
            return view('domicile.edit',  compact('genders','tehsils', 'districts', 'provinces', 'maritalStatuses','qualifications','occupations','applicant','request_types','service_types','payment_types','approvers'));
        }
    

    public function update(Request $request, $id)
    {
    
    $domicile = DomicileApplicants::findOrFail($id);
    
    $validated = $request->validate([
        'cnic' => 'required|string|max:13',
        'first_name' => 'required|string|max:45',
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
        'arrival_date' => 'nullable|date',
        'remarks'=>'nullable|string|max:80',

        // Present Address
        'present_province_id' => 'required|integer',
        'present_district_id' => 'required|integer',
        'present_tehsil_id' => 'required|integer',
        'present_address' => 'required|string|max:100',

        // Permanent Address
        'permanent_province_id' => 'required|integer',
        'permanent_district_id' => 'required|integer',
        'permanent_tehsil_id' => 'required|integer',
        'permanent_address' => 'required|string|max:100',

        // Service Details
        'application_type_id' => 'nullable|integer',
        'request_type_id' => 'nullable|integer',
        'service_type_id' => 'nullable|integer',
        'payment_type_id' => 'nullable|integer',
        'purpose' => 'nullable|string|max:45',
        'priority_type' => 'nullable|string|max:10',
        'receipt_no' => 'nullable|string|max:100',
        'approver_id' => 'nullable|integer',

        'children_checkbox' => 'nullable|string',

        // Children (optional)
        'children.*.id' => 'nullable|integer',
        'children.*.cnic' => 'required|string',
        'children.*.name' => 'required|string',
        'children.*.dob' => 'required|date',
        'children.*.gender_id' => 'required|in:1,2',
    ]);

    // 🔹 Update applicant info
    $domicile->update([
        'cnic' => strtoupper($validated['cnic']),
        'first_name' => strtoupper($validated['first_name']),
        'father_name' => strtoupper($validated['father_name']),
        'spouse_name' => strtoupper($validated['spouse_name']),
        'date_of_birth' => $validated['date_of_birth'],
        'gender_id' => $validated['gender_id'],
        'place_of_birth' => $validated['place_of_birth'],
        'marital_status_id' => $validated['marital_status_id'],
        'religion' => strtoupper($validated['religion']),
        'qualification_id' => $validated['qualification_id'],
        'occupation_id' => $validated['occupation_id'],
        'contact' => $validated['contact'],
        'arrival_date' => $validated['arrival_date'],

         // Service Details
        'application_type_id' => $validated['application_type_id'] ?? $domicile->application_type_id,
        'request_type_id' => $validated['request_type_id'] ?? $domicile->request_type_id,
        'service_type_id' => $validated['service_type_id'] ?? $domicile->service_type_id,
        'payment_type_id' => $validated['payment_type_id'] ?? $domicile->payment_type_id, 
        'receipt_no' => $validated['receipt_no'] ?? $domicile->receipt_no,
        'purpose' => $validated['purpose'] ?? $domicile->purpose,
        'priority_type' => $validated['priority_type'] ?? $domicile->priority_type,
        'approver_id' => $validated['approver_id'] ?? $domicile->approver_id,
        'remarks' => $validated['remarks'],
        'present_province_id' => $validated['present_province_id'],
        'present_district_id' => $validated['present_district_id'],
        'present_tehsil_id' => $validated['present_tehsil_id'],
        'present_address' => strtoupper($validated['present_address']),

        'permanent_province_id' => $validated['permanent_province_id'],
        'permanent_district_id' => $validated['permanent_district_id'],
        'permanent_tehsil_id' => $validated['permanent_tehsil_id'],
        'permanent_address' => strtoupper($validated['permanent_address']),
    ]);

    // 🔹 Sync children
    $submittedChildren = $request->input('children', []);

    // Existing child IDs in DB
    $existingIds = $domicile->children()->pluck('id')->toArray();

    // Submitted child IDs
    $submittedIds = collect($submittedChildren)
        ->pluck('id')
        ->filter()
        ->toArray();

    // Delete removed children
    $toDelete = array_diff($existingIds, $submittedIds);

    if (!empty($toDelete)) {
        children::whereIn('id', $toDelete)->delete();
    }

    // Update or Create children
    foreach ($submittedChildren as $childData) {

        // Skip empty rows
        if (
            empty($childData['name']) &&
            empty($childData['cnic'])
        ) {
            continue;
        }

        if (!empty($childData['id'])) {

            // Update existing child
            $child = children::find($childData['id']);

            if ($child) {
                $child->update([
                    'cnic' => $childData['cnic'],
                    'name' => $childData['name'],
                    'date_of_birth' => $childData['dob'],
                    'gender_id' => $childData['gender_id'],
                ]);
            }

        } else {

            // Create new child
            children::create([
                'applicant_id' => $domicile->id,
                'cnic' => $childData['cnic'],
                'name' => $childData['name'],
                'date_of_birth' => $childData['dob'],
                'gender_id' => $childData['gender_id'],
            ]);
        }
    }

        return redirect()->route('domicile.index')->with('success', 'Domicile record updated successfully.');
    }

    public function form_p($id){

        $applicant = DomicileApplicants::with('children', 'occupations', 'marital_statuses')
                                        ->findOrFail($id);
        // return $applicant;
        if ($applicant){
            return view('domicile.form-p', compact('applicant'));
        } else {
            return view('domicile.norecord');
        }
        
    }
    public function dom_tehsils(){
        $tehsils = tehsils::all();
        return $tehsils;
    }
    public function dom_districts(){
        $districts = districts::all();
        return $districts;
    }
    public function apiCheck(Request $request)
    {
        session()->forget(['status', 'error']);

        $request->validate([
            'cnic' => ['required', 'regex:/^[0-9]{13}$/']
        ], [
            'cnic.regex' => 'CNIC format must be like 6110145612378'
        ]);

        // Fetch the domicile record
        $data = DomicileStatus::where('cnic', $request->cnic)->first();
        
        if ($data) {
            // Convert to array so you can access like session('status')['Status']
            return redirect()->back()->with('status', $data->toArray());
        } else {
            return redirect()->back()->with('error', 'Record not found');
        }
    }


    public function get_statistics()
    {
        // Check if cached value exists
        $stats = Cache::get('counters');

        if (!$stats) {
            // If not cached, fetch fresh data
            $stats = $this->fetchAndUpdateCounters();
        }

        return response()->json($stats, 200);
    }

    private function fetchAndUpdateCounters()
    {
        try {
            $response = Http::timeout(60) // 60 seconds
                        ->get('http://127.0.0.1:8000/domicile/statistics/check');

            if ($response->successful()) {
                $data = $response->json();

                $marriageCertificates = 4523; // Or DB::table(...)->count();
                $mrc_count = DB::table('mrc_status')->count();
                $marriageCertificates = $marriageCertificates + $mrc_count;
                $finalData = [
                    'marriage_certificates' => $marriageCertificates,
                    'domiciles' => $data['domicile'] ?? 0,
                    'driving_permits' => $data['idp'] ?? 0,
                ];
                Log::info('Fetched stats from API', $finalData);
                // \Log::info('Cache value after storing', Cache::get('counters'));
                // Save in cache for 1 hour
                Cache::put('counters', $finalData, now()->addHour());

                return $finalData;
            } else {
                return ['error' => 'Python API error'];
            }
        } catch (\Exception $e) {
            return ['error' => 'Something went wrong: ' . $e->getMessage()];
        }
    }
    
}
