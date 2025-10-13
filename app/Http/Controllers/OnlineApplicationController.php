<?php

namespace App\Http\Controllers;

use App\Models\ApplicationType;
use App\Models\NocApplicants;
use App\Models\NocLetters;
use App\Models\OnlineApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlineApplicationController extends Controller
{
    public function dashboard()
    {   $user= Auth::user();
        $query = OnlineApplication::with(['application_status', 'application_type', 'user']);
        if ($user->role->role==='admin'){
            $applications = $query->orderBy('id', 'desc')->get();
        }else{
            if ($user->role->role==='customer'){
                $query->where('created_by', $user->id);
            }else{
                $query->where('role_id', $user->role_id);
            }
            $applications = $query->orderBy('id', 'desc')->get();
        }
        $services = ApplicationType::all();
        return view('dashboard', compact('applications', 'services'));
    }
    public function online_application_show($id)
    {   $online_app = OnlineApplication::findOrFail($id);
        if ($online_app->application_type_id===1){
            return view('online.noc-to-other-district.show');
        }
        $nocLetter = NocLetters::with('nocapplicants')->where('app_id', $id)->get();
        return $nocLetter;
        return view('online.noctootherdistrict');
    }
    public function noc_to_other_district_create()
    {
        return view('online.noc-to-other-district.create');
    }
    public function noc_to_other_district_store(Request $request)
    {
        $request->validate([
            'letterType'             => 'required|string|in:Self,Official',
            'applicantName'          => 'required|array',
            'applicantCnic'          => 'required|array',
            'applicantRelation'      => 'required|array',
            'applicantFather'        => 'required|array',
            'district'               => 'required|string',
            'referenced_letter_no'   => 'nullable|string',
            'referenced_letter_date' => 'nullable|date',
            'documents'              => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Step 1: Upload document if provided
        $path = null;
        if ($request->hasFile('documents')) {
            $file = $request->file('documents');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('noc_other_district_documents', $filename, 'public');
        }

        // Step 2: Create NOC Letter
        $letterData = [
            'district' => $request->district,
        ];

        if ($request->letterType !== 'Self') {
            if (!$request->referenced_letter_no || !$request->referenced_letter_date) {
                return back()->withErrors(['referenced_letter' => 'Reference number and date required.']);
            }
            $letterData['referenced_letter_no']   = $request->referenced_letter_no;
            $letterData['referenced_letter_date'] = $request->referenced_letter_date;
        }

        $nocLetter = NocLetters::create($letterData);

        // Step 3: Save Applicants
        foreach ($request->applicantName as $i => $name) {
            NocApplicants::create([
                'letter_id'            => $nocLetter->id,
                'applicant_name'       => $name,
                'cnic'                 => $request->applicantCnic[$i],
                'relation'             => $request->applicantRelation[$i],
                'applicant_father_name'=> $request->applicantFather[$i],
            ]);
        }

        // Step 4: Create Online Application
        $onlineapplication = OnlineApplication::create([
            'application_type_id'   => 1,
            'application_status_id' => 1,
            'role_id'               => 2,
            'documents'             => $path, // store uploaded file path
        ]);

        // Step 5: Link Online Application with NOC Letter
        $nocLetter->app_id = $onlineapplication->id;
        $nocLetter->save(); 

        return redirect()->route('dashboard')->with('success', 'Your Application for NOC to other District has been submitted.');
    }

    public function noc_to_other_district_edit($id)
    {

    }

}
