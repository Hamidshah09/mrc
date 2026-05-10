<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VerificationLetter;
use App\Models\VerificationLetterApplicants;
use App\Models\DispatchDiary;
class VerificationLetterController extends Controller
{
    public function create()
    {
        return view('domicile-verification.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Letter_Date' => 'required|date',
            'Letter_No' => 'required|string|max:70',
            'Letter_Sent_by' => 'required|string|max:50',
            'Designation' => 'nullable|string|max:70',
            'Sender_Address' => 'nullable|string|max:150',
            'Letter_Issuance_Date' => 'nullable|date',
            'Remarks' => 'nullable|string|max:45',
        ]);

        $verificationLetter = VerificationLetter::create([
            'Letter_Date' => $request->input('Letter_Date'),
            'Letter_No' => $request->input('Letter_No'),
            'Letter_Sent_by' => $request->input('Letter_Sent_by'),
            'Designation' => $request->input('Designation'),
            'Sender_Address' => $request->input('Sender_Address'),
            'Letter_Issuance_Date' => now(),
            'Remarks' => $request->input('Remarks'),

        ]);

        $letterId = $verificationLetter->Letter_ID;
        
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
            'Letter_Type' => 'Verification Letter',
            'Letter_ID' => $letterId,
        ]);
        $applicants = $request->input('applicants', []);
        if (is_array($applicants) && count($applicants) > 0) {
            foreach ($applicants as $app) {
                // skip completely empty rows
                if (empty(array_filter($app))) {
                    continue;
                }

                VerificationLetterApplicants::create([
                    'Letter_ID' => $letterId,
                    'Applicant_Name' => $app['Applicant_Name'] ?? null,
                    'CNIC' => $app['CNIC'] ?? null,
                    'Relation' => $app['Relation'] ?? null,
                    'Applicant_FName' => $app['Applicant_FName'] ?? null,
                    'Domicile_No' => $app['Domicile_No'] ?? null,
                    'Domicile_Date' => $app['Domicile_Date'] ?? null,
                    'address' => $app['address'] ?? null,

                ]);
            }
        }

        return redirect()->route('domicile.verification_letter.index')->with('success', 'Verification Letter created successfully.');
    }

    public function index(Request $request)
    {
        $query = VerificationLetter::with('applicants', 'dispatchDiary')->orderBy('Letter_ID', 'desc');

        if ($request->filled('Letter_No')) {
            $query->where('Letter_No', 'like', '%'.$request->input('Letter_No').'%');
        }

        if ($request->filled('Letter_Sent_by')) {
            $query->where('Letter_Sent_by', 'like', '%'.$request->input('Letter_Sent_by').'%');
        }

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function($q) use ($search) {
                $q->where('Letter_No', 'like', '%'.$search.'%')
                  ->orWhere('Letter_Sent_by', 'like', '%'.$search.'%')
                  ->orWhere('Sender_Address', 'like', '%'.$search.'%')
                  ->orWhere('Remarks', 'like', '%'.$search.'%');
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('Letter_Date', '>=', $request->input('from_date'));
        }
        if ($request->filled('to_date')) {
            $query->whereDate('Letter_Date', '<=', $request->input('to_date'));
        }

        // filter by applicant name (search in related applicants)
        if ($request->filled('applicant_name')) {
            $name = $request->input('applicant_name');
            $query->whereHas('applicants', function($q) use ($name) {
                $q->where('Applicant_Name', 'like', '%'.$name.'%');
            });
        }

        // filter by applicant CNIC
        if ($request->filled('cnic')) {
            $cnic = $request->input('cnic');
            $query->whereHas('applicants', function($q) use ($cnic) {
                $q->where('CNIC', 'like', '%'.$cnic.'%');
            });
        }

        $letters = $query->paginate(10)->appends($request->except('page'));
        return view('domicile-verification.index', compact('letters'));
    }
    public function edit($id)
    {
        $letter = VerificationLetter::with('applicants', 'dispatchDiary')->findOrFail($id);
        return view('domicile-verification.edit', compact('letter'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'Letter_Date' => 'required|date',
            'Letter_No' => 'required|string|max:70',
            'Letter_Sent_by' => 'required|string|max:50',
            'Designation' => 'nullable|string|max:70',
            'Sender_Address' => 'nullable|string|max:150',
            'Letter_Issuance_Date' => 'nullable|date',
            'Remarks' => 'nullable|string|max:45',
        ]);

        $letter = VerificationLetter::findOrFail($id);
        $letter->update([
            'Letter_Date' => $request->input('Letter_Date'),
            'Letter_No' => $request->input('Letter_No'),
            'Letter_Sent_by' => $request->input('Letter_Sent_by'),
            'Designation' => $request->input('Designation'),
            'Sender_Address' => $request->input('Sender_Address'),
            'Letter_Issuance_Date' => now(),
            'Remarks' => $request->input('Remarks'),
        ]);
        $applicants = $request->input('applicants', []);

        // existing applicant IDs
        $existingIds = VerificationLetterApplicants::where('Letter_ID', $id)->pluck('App_ID')->map(function($v){ return (int)$v; })->toArray();

        $incomingIds = [];
        if (is_array($applicants) && count($applicants) > 0) {
            foreach ($applicants as $app) {
                if (empty(array_filter($app))) {
                    continue;
                }
                $appId = isset($app['App_ID']) ? (int)$app['App_ID'] : 0;
                if ($appId > 0) $incomingIds[] = $appId;
            }
        }

        // delete applicants removed on frontend
        $toDelete = array_diff($existingIds, $incomingIds);
        if (!empty($toDelete)){
            VerificationLetterApplicants::whereIn('App_ID', $toDelete)->delete();
        }

        // process incoming: update existing, create new
        if (is_array($applicants) && count($applicants) > 0) {
            foreach ($applicants as $app) {
                if (empty(array_filter($app))) {
                    continue;
                }
                $appId = isset($app['App_ID']) ? (int)$app['App_ID'] : 0;
                $data = [
                    'Letter_ID' => $id,
                    'Applicant_Name' => $app['Applicant_Name'] ?? null,
                    'CNIC' => $app['CNIC'] ?? null,
                    'Relation' => $app['Relation'] ?? null,
                    'Applicant_FName' => $app['Applicant_FName'] ?? null,
                    'address' => $app['address'] ?? null,
                    'Domicile_No' => $app['Domicile_No'] ?? null,
                    'Domicile_Date' => $app['Domicile_Date'] ?? null,
                ];

                if ($appId > 0) {
                    VerificationLetterApplicants::where('App_ID', $appId)->update($data);
                } else {
                    VerificationLetterApplicants::create($data);
                }
            }
        }
        return redirect()->route('domicile.verification_letter.index')->with('success', 'Verification Letter updated successfully.');
    }
    public function issueletter($id){
        $letter = VerificationLetter::with('applicants', 'dispatchDiary')->find($id);
        if (!$letter){
            return redirect()->route('domicile.verification_letter.index')->withErrors(['notfound' => 'Letter not found']);
        }
        $pdf = \PDF::loadView('domicile-verification.letter', compact('letter'));
        return $pdf->stream('Verification_Letter_'.$letter->Letter_ID.'.pdf');
    }
}
