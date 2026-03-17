<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NocICT;
use App\Models\NocICTApplicants;
use App\Models\DispatchDiary;
class NocIctController extends Controller
{
    public function noc_ict_create(){
        return view('nocict.createnocict');
    }
    public function noc_ict_store(Request $request){
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

                NocICTApplicants::create([
                    'Letter_ID' => $letterId,
                    'Applicant_Name' => $app['Applicant_Name'] ?? null,
                    'CNIC' => $app['CNIC'] ?? null,
                    'Relation' => $app['Relation'] ?? null,
                    'Applicant_FName' => $app['Applicant_FName'] ?? null,
                ]);
            }
        }

        return redirect()->route('noc-ict.create')->with('success', 'NOC ICT record saved successfully.');
    }
    public function noc_ict_index(Request $request){
        // Apply search filter based on search_type
        $query = NocICT::with('applicants', 'dispatchDiary')->orderBy('Letter_ID','desc');
        if ($request->filled('search') && $request->filled('search_type')) {
            $search = $request->search;
            $searchType = $request->search_type;

            switch ($searchType) {
                case 'cnic':
                    $query->whereHas('applicants', function ($q) use ($search) {
                        $q->where('CNIC', 'like', '%' . $search . '%'); // Adjust field name if needed
                    });
                    break;
                case 'name':
                    $query->whereHas('applicants', function ($q) use ($search) {
                        $q->where('Applicant_Name', 'like', '%' . $search . '%');
                    });
                    break;
                case 'id':
                    $query->where('Letter_ID', 'like', '%' . $search . '%');
                    break;
                case 'dispatch_no':
                    $query->whereHas('dispatchDiary', function ($q) use ($search) {
                        $q->where('Dispatch_No', 'like', '%' . $search . '%');
                    });
                    break;
            }
        }

        // Apply date range filter
        if ($request->filled('from_date')) {
            $query->where('Letter_Date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->where('Letter_Date', '<=', $request->to_date);
        }

        // Paginate and append query params for filter persistence
        $letters = $query->paginate(10)->appends($request->query());

        return view('nocict.index', compact('letters'));
    }

    public function noc_ict_edit($id){
        $letter = NocICT::find($id);
        if (!$letter){
            return redirect()->route('noc-ict.index')->withErrors(['notfound' => 'Letter not found']);
        }
        $letter = NocICT::with('applicants')->where('Letter_ID', $id)->first();
        return view('nocict.edit', compact('letter'));
    }

    public function noc_ict_update(Request $request, $id){
        $validated = $request->validate([
            'letter.Letter_Date' => 'nullable|date',
            'letter.Letter_Sent_to' => 'required|string|max:255',
            'letter.Remarks' => 'nullable|string|max:500',
            'applicants' => 'nullable|array',
            'applicants.*.App_ID' => 'nullable|integer',
            'applicants.*.CNIC' => 'nullable|string|max:30',
            'applicants.*.Applicant_Name' => 'nullable|string|max:255',
            'applicants.*.Relation' => 'nullable|string|max:50',
            'applicants.*.Applicant_FName' => 'nullable|string|max:255',
        ]);

        $letter = NocICT::find($id);
        if (!$letter){
            return redirect()->route('noc-ict.index')->withErrors(['notfound' => 'Letter not found']);
        }

        $letterInput = $request->input('letter', []);
        $letter->update([
            'letter_date' => $letterInput['Letter_Date'] ?? null,
            'letter_sent_to' => $letterInput['Letter_Sent_to'] ?? null,
        ]);

        $applicants = $request->input('applicants', []);

        // existing applicant IDs
        $existingIds = NocICTApplicants::where('Letter_ID', $id)->pluck('App_ID')->map(function($v){ return (int)$v; })->toArray();

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
            NocICTApplicants::whereIn('App_ID', $toDelete)->delete();
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
                ];

                if ($appId > 0) {
                    NocICTApplicants::where('App_ID', $appId)->update($data);
                } else {
                    NocICTApplicants::create($data);
                }
            }
        }

        return redirect()->route('noc-ict.index')->with('success', 'NOC ICT record updated.');
    }

    public function generateLetter($id){
        $letter = NocICT::with('applicants', 'dispatchDiary')->find($id);
        if (!$letter){
            return redirect()->route('noc-ict.index')->withErrors(['notfound' => 'Letter not found']);
        }
        $pdf = \PDF::loadView('nocict.letter', compact('letter'));
        return $pdf->download('NOC_ICT_Letter_'.$letter->Letter_ID.'.pdf');
    }
}
