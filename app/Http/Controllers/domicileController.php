<?php

namespace App\Http\Controllers;

use App\Models\children;
use App\Models\districts;
use App\Models\DomicileApplicants;
use App\Models\NocApplicants;
use App\Models\NocLetters;
use App\Models\Passcode;
use App\Models\tehsils;
use Illuminate\Http\Request;

class domicileController extends Controller
{
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
        'cnic' => 'required|string|max:13|min:13',
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
        'contact' => 'nullable|string|max:15',
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

    return redirect()->route('noc.success', $domicile->id);;
}

    public function create_noc(){
        $passcode = Passcode::whereDate('valid_on', today())->where('used', 'No')->first();
        if (!$passcode){
            return view('domicile.nocode');
        }
        $passcode->update([
        'used' => 'In Process',
        ]);
        return view('domicile/noc', compact('passcode'));
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

    public function store_noc(Request $request){
        
        $passcode = Passcode::where([
            ['code', '=', $request->code],
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
    public function success($id){

        return view('domicile.recordid', compact('id'));
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
        $applicant = DomicileApplicants::with('children', 'occupations', 'marital_statuses')->findOrFail($id);
        // return $applicant;
        return view('domicile.form-p', compact('applicant'));
    }
}
