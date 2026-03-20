<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VerificationLetter;
use App\Models\VerificationLetterApplicant;
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
            'Letter_Sent_by' => 'required|string|max:255',
            'Designation' => 'nullable|string|max:255',
            'Sender_Address' => 'nullable|string|max:255',
            'Letter_Issuance_Date' => 'nullable|date',
            'Remarks' => 'nullable|string|max:255',
        ]);

        $verificationLetter = VerificationLetter::create([
            'Letter_Date' => $request->input('Letter_Date'),
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

                VerificationLetterApplicant::create([
                    'Letter_ID' => $letterId,
                    'Applicant_Name' => $app['Applicant_Name'] ?? null,
                    'CNIC' => $app['CNIC'] ?? null,
                    'Relation' => $app['Relation'] ?? null,
                    'Applicant_FName' => $app['Applicant_FName'] ?? null,
                    'Domicile_No' => $app['Domicile_No'] ?? null,
                    'Domicile_Date' => $app['Domicile_Date'] ?? null,

                ]);
            }
        }

        return redirect()->route('domicile.verification_letter.index')->with('success', 'Verification Letter created successfully.');
    }

    public function index(Request $request)
    {
        $letters = VerificationLetter::with('applicants', 'dispatchDiary')->orderBy('Letter_ID', 'desc')->get();
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
            'Letter_Sent_by' => 'required|string|max:255',
            'Designation' => 'nullable|string|max:255',
            'Sender_Address' => 'nullable|string|max:255',
            'Letter_Issuance_Date' => 'nullable|date',
            'Remarks' => 'nullable|string|max:255',
        ]);

        $letter = VerificationLetter::findOrFail($id);
        $letter->update([
            'Letter_Date' => $request->input('Letter_Date'),
            'Letter_Sent_by' => $request->input('Letter_Sent_by'),
            'Designation' => $request->input('Designation'),
            'Sender_Address' => $request->input('Sender_Address'),
            'Letter_Issuance_Date' => now(),
            'Remarks' => $request->input('Remarks'),
        ]);
        $applicants = $request->input('applicants', []);

        // existing applicant IDs
        $existingIds = VerificationLetterApplicant::where('Letter_ID', $id)->pluck('App_ID')->map(function($v){ return (int)$v; })->toArray();

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
            VerificationLetterApplicant::whereIn('App_ID', $toDelete)->delete();
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
                    'Domicile_No' => $app['Domicile_No'] ?? null,
                    'Domicile_Date' => $app['Domicile_Date'] ?? null,
                ];

                if ($appId > 0) {
                    VerificationLetterApplicant::where('App_ID', $appId)->update($data);
                } else {
                    VerificationLetterApplicant::create($data);
                }
            }
        }
    }
    public function issueletter($id){
        $letter = VerificationLetter::with('applicants', 'dispatchDiary')->find($id);
        if (!$letter){
            return redirect()->route('domicile-verification.index')->withErrors(['notfound' => 'Letter not found']);
        }
        $pdf = \PDF::loadView('domicile-verification.letter', compact('letter'));
        return $pdf->download('Verification_Letter_'.$letter->Letter_ID.'.pdf');
    }
}
