<?php

namespace App\Http\Controllers;

use App\Models\children;
use App\Models\districts;
use App\Models\DomicileApplicants;
use App\Models\DomicileStatus;
use App\Models\NocApplicants;
use App\Models\NocLetters;
use App\Models\OnlineApplication;
use App\Models\Passcode;
use App\Models\tehsils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class domicileController extends Controller
{   
    public function admin_index(){
        $records = DomicileApplicants::select('id', 'name', 'passcode')->orderBy('id', 'desc')->paginate(25);
        return view('domicile.adminindex', compact('records'));
    }
    public function dom_index(){
        $records = DomicileApplicants::select('id', 'name')->orderBy('id', 'desc')->paginate(25);
        return view('domicile.domicileindex', compact('records'));
    }
    public function create_new(){
        $tehsils = tehsils::orderBy('Teh_name')->get();
        $districts = districts::orderBy('Dis_Name')->get();
        $passcode = Passcode::whereDate('valid_on', today())->where('used', 'No')->first();
        if (!$passcode){
            return view('domicile.nocode');
        }
        $passcode->update([
            'used' => 'In Process',
        ]);
        return view('domicile.createnew',  compact('tehsils', 'districts', 'passcode'));
    }
    public function store_new(Request $request)
    {   
        
        $passcode = Passcode::where([
                ['code', '=', $request->passcode],
                ['valid_on', '=', today()],
                ['used', '=', 'In Process']
            ])->first();

        if (!$passcode) {
            return back()->withErrors(['code' => 'Invalid or already used passcode.']);
        }
    $validated = $request->validate([
        'cnic' => 'required|regex:/^[0-9]{13}$/',
        'name' => 'required|string|max:255',
        'fathername' => 'required|string|max:255',
        'spousename' => 'nullable|string|max:255',
        'date_of_birth' => 'required|date',
        'gender_id' => 'required|integer',
        'place_of_birth' => 'required|string|max:255',
        'marital_status_id' => 'required|integer',
        'religion' => 'required|string|max:45',
        'qualification_id' => 'nullable|integer',
        'occupation_id' => 'nullable|integer',
        'contact' => 'nullable|string|max:11',
        'date_of_arrival' => 'required|date',
        'passcode'=>'string|min:6|max:6',

        // Temporary Address
        'temporaryAddress_province_id' => 'required|integer',
        'temporaryAddress_district_id' => 'required|integer',
        'temporaryAddress_tehsil_id' => 'required|integer',
        'temporaryAddress' => 'required|string|max:255',

        // Permanent Address
        'permanentAddress_province_id' => 'required|integer',
        'permanentAddress_district_id' => 'required|integer',
        'permanentAddress_tehsil_id' => 'required|integer',
        'permanentAddress' => 'required|string|max:255',

        'children_checkbox' => 'nullable|boolean',
    ]);

    $request->validate([
    'children.*.cnic' => 'required|string',
    'children.*.name' => 'required|string',
    'children.*.dob' => 'required|date',
    'children.*.gender_id' => 'required|in:1,2',
    ]);

    $domicile = new DomicileApplicants();

    // Personal Info
    $domicile->cnic = strtoupper($validated['cnic']);
    $domicile->name = strtoupper($validated['name']);
    $domicile->fathername = strtoupper($validated['fathername']);
    $domicile->spousename = strtoupper($validated['spousename']); // nullable
    $domicile->date_of_birth = $validated['date_of_birth'];
    $domicile->gender_id = $validated['gender_id'];
    $domicile->place_of_birth = $validated['place_of_birth'];
    $domicile->marital_status_id = $validated['marital_status_id'];
    $domicile->religion = strtoupper($validated['religion']);
    $domicile->qualification_id = $request->input('qualification_id'); // nullable
    $domicile->occupation_id = $request->input('occupation_id'); // nullable
    $domicile->contact = $request->input('contact');
    $domicile->date_of_arrival = $request->input('date_of_arrival');
    $domicile->passcode =$validated['passcode'];

    // Temporary Address
    $domicile->temporaryAddress_province_id = $validated['temporaryAddress_province_id'];
    $domicile->temporaryAddress_district_id = $validated['temporaryAddress_district_id'];
    $domicile->temporaryAddress_tehsil_id = $validated['temporaryAddress_tehsil_id'];
    $domicile->temporaryAddress = strtoupper($validated['temporaryAddress']);

    // Permanent Address
    $domicile->permanentAddress_province_id = $validated['permanentAddress_province_id'];
    $domicile->permanentAddress_district_id = $validated['permanentAddress_district_id'];
    $domicile->permanentAddress_tehsil_id = $validated['permanentAddress_tehsil_id'];
    $domicile->permanentAddress = strtoupper($validated['permanentAddress']);

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
    
    $passcode->update([
        'used' => 'Yes',
        'submitted_by' => $domicile->id
    ]);

    return redirect()->route('domicile.success', [
    'id'   => $domicile->id,
    'cnic' => $domicile->cnic,
]);
    }
    public function dom_edit($id, $cnic){
        $tehsils = tehsils::orderBy('Teh_name')->get();
        $districts = districts::orderBy('Dis_Name')->get();
        $provinces = collect([
            (object)['ID'=>491, 'Province'=>'Balochistan'],
            (object)['ID'=>663, 'Province'=>'Federal Capital'],
            (object)['ID'=>1, 'Province'=>'Khyber Pakhtunkhwa'],
            (object)['ID'=>167, 'Province'=>'Punjab'],
            (object)['ID'=>344, 'Province'=>'Sindh'],
        ]);
        $qualifications = collect([
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
        $maritalStatuses = collect([
            (object)['id' => 1, 'name' => 'Single'],
            (object)['id' => 2, 'name' => 'Married'],
            (object)['id' => 3, 'name' => 'Divorced'],
            (object)['id' => 4, 'name' => 'Widowed'],
            (object)['id' => 5, 'name' => 'Widower'],
        ]);

        $occupations = collect([
            (object)['id' => 1, 'name' => 'Government Employee'],
            (object)['id' => 2, 'name' => 'Non Government Employee'],
            (object)['id' => 3, 'name' => 'Own Business'],
            (object)['id' => 4, 'name' => 'Student'],
            (object)['id' => 5, 'name' => 'Other'],
            (object)['id' => 6, 'name' => 'House wife'],
            (object)['id' => 7, 'name' => 'Private Job'],
        ]);
        $genders = collect([
            (object)['id' => 1, 'name' => 'Male'],
            (object)['id' => 2, 'name' => 'Female'],
            (object)['id' => 3, 'name' => 'Transgender'],
        ]);

        
        $applicant = DomicileApplicants::with('children')->where('id', $id)->where('cnic', $cnic)->whereDate('created_at', now()->toDateString())->first();
        if ($applicant){
            return view('domicile.domedit',  compact('genders','tehsils', 'districts', 'provinces', 'maritalStatuses','qualifications','occupations','applicant'));
        } else {
            return view('domicile.norecord');
        }
        // return $applicant;
        
    }
    public function dom_update(Request $request, $id)
    {
    
    $domicile = DomicileApplicants::findOrFail($id);
    if ($domicile->passcode!=$request->passcode){
        return back()->withErrors(['code' => 'Passcode mismatch']);
    } 
    $validated = $request->validate([
        'cnic' => 'required|string|max:13',
        'name' => 'required|string|max:255',
        'fathername' => 'required|string|max:255',
        'spousename' => 'nullable|string|max:255',
        'date_of_birth' => 'required|date',
        'gender_id' => 'required|integer',
        'place_of_birth' => 'required|string|max:255',
        'marital_status_id' => 'required|integer',
        'religion' => 'required|string|max:45',
        'qualification_id' => 'nullable|integer',
        'occupation_id' => 'nullable|integer',
        'contact' => 'nullable|string|max:11',
        'date_of_arrival' => 'nullable|date',

        // Temporary Address
        'temporaryAddress_province_id' => 'required|integer',
        'temporaryAddress_district_id' => 'required|integer',
        'temporaryAddress_tehsil_id' => 'required|integer',
        'temporaryAddress' => 'required|string|max:255',

        // Permanent Address
        'permanentAddress_province_id' => 'required|integer',
        'permanentAddress_district_id' => 'required|integer',
        'permanentAddress_tehsil_id' => 'required|integer',
        'permanentAddress' => 'required|string|max:255',

        'children_checkbox' => 'nullable|boolean',

        // Children (optional)
        'children.*.id' => 'nullable|integer|exists:childrens,id',
        'children.*.cnic' => 'required|string',
        'children.*.name' => 'required|string',
        'children.*.dob' => 'required|date',
        'children.*.gender_id' => 'required|in:1,2',
    ]);

    // 🔹 Update applicant info
    $domicile->update([
        'cnic' => strtoupper($validated['cnic']),
        'name' => strtoupper($validated['name']),
        'fathername' => strtoupper($validated['fathername']),
        'spousename' => strtoupper($validated['spousename']),
        'date_of_birth' => $validated['date_of_birth'],
        'gender_id' => $validated['gender_id'],
        'place_of_birth' => $validated['place_of_birth'],
        'marital_status_id' => $validated['marital_status_id'],
        'religion' => strtoupper($validated['religion']),
        'qualification_id' => $request->input('qualification_id'),
        'occupation_id' => $request->input('occupation_id'),
        'contact' => $request->input('contact'),
        'date_of_arrival' => $request->input('date_of_arrival'),

        'temporaryAddress_province_id' => $validated['temporaryAddress_province_id'],
        'temporaryAddress_district_id' => $validated['temporaryAddress_district_id'],
        'temporaryAddress_tehsil_id' => $validated['temporaryAddress_tehsil_id'],
        'temporaryAddress' => strtoupper($validated['temporaryAddress']),

        'permanentAddress_province_id' => $validated['permanentAddress_province_id'],
        'permanentAddress_district_id' => $validated['permanentAddress_district_id'],
        'permanentAddress_tehsil_id' => $validated['permanentAddress_tehsil_id'],
        'permanentAddress' => strtoupper($validated['permanentAddress']),
    ]);

    // 🔹 Sync children
    $submittedChildren = $request->input('children', []);

    // 1️⃣ Collect current child IDs from DB
    $existingIds = $domicile->children()->pluck('id')->toArray();

    // 2️⃣ Collect IDs submitted from form
    $submittedIds = collect($submittedChildren)->pluck('id')->filter()->toArray();

    // 3️⃣ Delete children that were removed
    $toDelete = array_diff($existingIds, $submittedIds);
    if (!empty($toDelete)) {
        children::whereIn('id', $toDelete)->delete();
    }

    // 4️⃣ Loop through submitted children (update or create)
    foreach ($submittedChildren as $childData) {
        if (!empty($childData['id'])) {
            // Update existing child
            $child = children::find($childData['id']);
            if ($child) {
                $child->update([
                    'cnic' => $childData['cnic'],
                    'child_name' => $childData['name'],
                    'date_of_birth' => $childData['dob'],
                    'gender_id' => $childData['gender_id'],
                ]);
            }
        } else {
            // Create new child
            children::create([
                'applicant_id' => $domicile->id,
                'cnic' => $childData['cnic'],
                'child_name' => $childData['name'],
                'date_of_birth' => $childData['dob'],
                'gender_id' => $childData['gender_id'],
            ]);
        }
    }

    return redirect()->route('domicile.success', [
                    'id'   => $domicile->id,
                    'cnic' => $domicile->cnic,
                ]);
    }

    public function create_noc(){
        $passcode = Passcode::whereDate('valid_on', today())->where('used', 'No')->first();
        if (!$passcode){
            return view('domicile.nocode');
        }
        $passcode->update([
        'used' => 'In Process',
        ]);
        return view('domicile.noc', compact('passcode'));
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
        
        $passcode = Passcode::where([
            ['code', '=', (string)$request->code],
            ['valid_on', '=', today()],
            ['used', '=', 'In Process']
        ])->first();

        if (!$passcode) {
            return back()->withErrors(['code' => 'Invalid or already used passcode.']);
        }

        $request->validate([
        'letterType'             => 'required|string',
        'applicantName'          => 'required|array',
        'applicantCnic'          => 'required|array',
        'applicantRelation'      => 'required|array',
        'applicantFather'        => 'required|array',
        'district'              => 'required|string',
        'referenced_letter_no'   => 'nullable|string',
        'referenced_letter_date' => 'nullable|date',
    ]);

        // Step 1: Create NOC Letter
    $letterData = [
        'district'    => $request->district,
    ];

    if ($request->letterType !== 'Self') {
        if (!$request->referenced_letter_no || !$request->referenced_letter_date) {
            return back()->withErrors(['referenced_letter' => 'Reference number and date required.']);
        }
        $letterData['referenced_letter_no']   = $request->referenced_letter_no;
        $letterData['referenced_letter_date'] = $request->referenced_letter_date;
    }

    $nocLetter = NocLetters::create($letterData);

    // Step 2: Save Applicants
    foreach ($request->applicantName as $i => $name) {
        

        $Nocapplicant = NocApplicants::create([
            'letter_id'         => $nocLetter->id,
            'applicant_name'        => $name,
            'cnic'        => $request->applicantCnic[$i],
            'relation'    => $request->applicantRelation[$i],
            'applicant_father_name' => $request->applicantFather[$i],
        ]);

    }

    // Mark as used and tie to applicant
    $passcode->update([
        'used' => 'Yes',
        'submitted_by' => $Nocapplicant->id
    ]);

    return redirect()->route('noc.success', $nocLetter->id);
    
    }
    public function noc_success($id){

        return view('domicile.recordid', compact('id'));
    }

    public function domicile_success($id, $cnic){

        return view('domicile.success', compact('id', 'cnic'));
    }

    public function show_domicile(Request $request)
    {
        $id = $request->query('id');
        $cnic = $request->query('cnic');

    // Start building the base query
        $query = DomicileApplicants::with('children')->withCount('children');

        
        if ($id) {
            $applicants = $query->find($id);

            if (!$applicants) {
                return response()->json([
                    'success' => false,
                    'message' => 'domicile record not found.'
                ], 404);
            }else{

                return response()->json([
                    'success' => true,
                    'data' => $applicants
                ], 200);
            }
        }

        // If no ID is provided but CNIC is
        if ($cnic) {
            $applicants = $query->where('cnic', 'like', '%'.$cnic.'%')->get();

            if ($applicants->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No records found for the provided CNIC.'
                ], 404);
            }else{
                return response()->json([
                'success' => true,
                'data' => $applicants
                ]);
            }
        }

        // If neither ID nor CNIC is provided
        $applicants = DomicileApplicants::with('children')->withCount('children')
        ->orderBy('id', 'desc') // or 'created_at' if you prefer timestamp
        ->take(200)
        ->get();

        return response()->json([
                'success' => true,
                'data' => $applicants
            ]);
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
                        ->get($this->apiUrl.'/domicile/statistics/check');

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
