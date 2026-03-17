<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NocOtherDistrict;
use App\Models\NocOtherDistrictApplicants;
use App\Models\DispatchDiary;
class NocOtherDistrictController extends Controller
{
    public function create(){
        return view('nocotherdistrict.create');
    }
    public function store(Request $request){
        
        $validated = $request->validate([
            'referenced_letter_no' => 'nullable|string|max:255',
            'referenced_letter_date' => 'nullable|date',
            'letter_type' => 'required|max:10',
            'Letter_Date' => 'required|date',
            'NOC_Issued_To' => 'required|string|max:60',
            'Remarks' => 'nullable|string|max:500',
            'applicants' => 'nullable|array',
            'applicants.*.CNIC' => 'required|string|max:13',
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

                NocOtherDistrictApplicants::create([
                    'Letter_ID' => $letterId,
                    'Applicant_Name' => $app['Applicant_Name'] ?? null,
                    'CNIC' => $app['CNIC'] ?? null,
                    'Relation' => $app['Relation'] ?? null,
                    'Applicant_FName' => $app['Applicant_FName'] ?? null,
                ]);
            }
        }

        return redirect()->route('noc-other-district.index')->with('success', 'NOC Other District record saved successfully.');
    }
    public function index(Request $request){
        $query = NocOtherDistrict::with('applicants', 'dispatchDiary')->orderBy('Letter_ID','desc');

        // Apply search filter based on search_type
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


        return view('nocotherdistrict.index', compact('letters'));
    }

    public function edit($id){
        $letter = NocOtherDistrict::find($id);
        if (!$letter){
            return redirect()->route('noc-other-district.index')->withErrors(['notfound' => 'Letter not found']);
        }
        $letter = NocOtherDistrict::with('applicants')->where('Letter_ID', $id)->first();
        return view('nocotherdistrict.edit', compact('letter'));
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'Letter_Date' => 'required|date',
            'letter_type' => 'required|in:self,official|max:10',
            'NOC_Issued_To' => 'required|string|max:255',
            'Remarks' => 'nullable|string|max:500',
            'applicants' => 'nullable|array',
            'applicants.*.App_ID' => 'nullable|integer',
            'applicants.*.CNIC' => 'nullable|string|max:30',
            'applicants.*.Applicant_Name' => 'nullable|string|max:255',
            'applicants.*.Relation' => 'nullable|string|max:50',
            'applicants.*.Applicant_FName' => 'nullable|string|max:255',
        ]);

        $letter = NocOtherDistrict::find($id);
        if (!$letter){
            return redirect()->route('noc-other-district.index')->withErrors(['notfound' => 'Letter not found']);
        }

        
        $letter->update([
            'Letter_Date' => $validated['Letter_Date'] ?? null,
            'letter_type' => $validated['letter_type'] ?? 'self',
            'NOC_Issued_To' => $validated['NOC_Issued_To'] ?? null,
            'Remarks' => $validated['Remarks'] ?? null,
            'referenced_letter_no' => $validated['referenced_letter_no'] ?? null,
            'referenced_letter_date' => $validated['referenced_letter_date'] ?? null,
        ]);

        $applicants = $request->input('applicants', []);

        // existing applicant IDs
        $existingIds = NocOtherDistrictApplicants::where('Letter_ID', $id)->pluck('App_ID')->map(function($v){ return (int)$v; })->toArray();

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
            NocOtherDistrictApplicants::whereIn('App_ID', $toDelete)->delete();
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
                    NocOtherDistrictApplicants::where('App_ID', $appId)->update($data);
                } else {
                    NocOtherDistrictApplicants::create($data);
                }
            }
        }

        return redirect()->route('noc-other-district.index')->with('success', 'NOC Other District record updated.');
    }

    public function issueletter($id){
        $letter = NocOtherDistrict::with('applicants', 'dispatchDiary')->find($id);
        if (!$letter){
            return redirect()->route('noc-other-district.index')->withErrors(['notfound' => 'Letter not found']);
        }
        $pdf = \PDF::loadView('nocotherdistrict.letter', compact('letter'));
        // return view('nocotherdistrict.letter', compact('letter'));
        return $pdf->download('NOC_Other_District_Letter_'.$letter->Letter_ID.'.pdf');
    }
}
