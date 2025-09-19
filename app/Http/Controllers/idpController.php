<?php

namespace App\Http\Controllers;

use App\Models\districts;
use App\Models\idp;
use App\Models\occupation;
use App\Models\Passcode;
use App\Models\tehsils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class idpController extends Controller
{
    public function create(){
        $passcode = Passcode::whereDate('valid_on', today())->where('used', 'No')->first();
        if (!$passcode){
            return view('domicile.nocode');
        }
        $passcode->update([
            'used' => 'In Process',
        ]);
        $districts = districts::all();
        $tehsils = tehsils::all();
        return view('idp.create', compact('districts','tehsils', 'passcode'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'gender_id' => 'nullable|integer',
            'date_of_birth' => 'nullable|date',
            'cnic' => 'nullable|string|max:20',
            'place_of_birth' => 'nullable|string|max:255',
            'qualification_id' => 'nullable|integer',
            'occupation_id' => 'nullable|integer',
            'temporary_address_province_id' => 'nullable|integer',
            'temporary_address_district_id' => 'nullable|integer',
            'temporary_address_tehsil_id' => 'nullable|integer',
            'temporary_address' => 'nullable|string|max:500',
            'contact' => 'nullable|string|max:20',
            'driving_license_number' => 'nullable|string|max:100',
            'driving_license_issue_date' => 'nullable|date',
            'driving_license_expiry_date' => 'nullable|date',
            'driving_license_vehicle_type_id' => 'nullable|integer',
            'driving_license_issuing_authority' => 'nullable|string|max:255',
            'passport_number' => 'nullable|string|max:100',
            'passport_issue_date' => 'nullable|date',
            'passport_expiry_date' => 'nullable|date',
            'passport_type_id' => 'nullable|integer',
        ]);

        $idp = idp::create($validated);

        return redirect()->route('idp.success', [
            'id'   => $idp->id,
            'cnic' => $idp->cnic,
        ]);
    }
    public function edit($id, $cnic){
        $districts = districts::all();
        $tehsils = tehsils::all();
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
        $genders = collect([
            (object)['id' => 1, 'name' => 'Male'],
            (object)['id' => 2, 'name' => 'Female'],
            (object)['id' => 3, 'name' => 'Transgender'],
        ]);
        $occupations = occupation::all();
        $idp = idp::where('id', $id)->where('cnic', $cnic)->whereDate('created_at', now()->toDateString())->first();
        if ($idp){
            return view('idp.edit',  compact('genders','tehsils', 'districts', 'provinces','qualifications','occupations','idp'));
        } else {
            return view('domicile.norecord');
        }

    }
    public function update($id){

    }
    public function success($id, $cnic){

        return view('idp.success', compact('id', 'cnic'));
    }

    public function check(Request $request)
    {
        session()->forget('status');
        session()->forget('error');
        $request->validate([
            'idp' => ['required', 'regex:/^\d+$/'],
        ], [
            'idp.regex' => 'IDP must contain only digits (no spaces or dashes).'
        ]);

        try {
            // Example API call (replace with your API URL)
            $response = Http::get($this->apiUrl.'/idp/check', [
                'idp' => $request->idp,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['error'])) {
                    return redirect()->back()->with('error', $data['error']);
                }
                return redirect()->back()->with('status', $data);
            }else{
                return redirect()->back()->with('error', $response->json()['error']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: '.$e->getMessage());
        }

    }
}
