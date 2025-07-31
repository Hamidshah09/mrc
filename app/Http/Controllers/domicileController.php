<?php

namespace App\Http\Controllers;

use App\Models\NocApplicants;
use App\Models\NocLetters;
use App\Models\Passcode;
use Illuminate\Http\Request;

class domicileController extends Controller
{
    public function create_noc(){
        return view('domicile/noc');
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
            ['used', '=', false]
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
        $cnic = $request->applicantCnic[$i];

        // Check if CNIC already exists
        if (NocApplicants::where('cnic', $cnic)->exists()) {
            return back()->withErrors([
                "applicantCnic.$i" => "CNIC $cnic already exists in the records."
            ]);
        }

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
        'used' => true,
        'submitted_by' => $Nocapplicant->id
    ]);

    return redirect()->route('noc.success', $nocLetter->id);
    
    }
    public function success($id){

        return view('domicile.recordid', compact('id'));
    }
}
