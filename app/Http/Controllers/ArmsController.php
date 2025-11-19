<?php

namespace App\Http\Controllers;

use App\Models\ArmsApproval;
use App\Models\ArmsLicense;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ArmsController extends Controller
{   
    protected $fastapiUrl;
    public function __construct()
    {
        // point this to your server's FastAPI base URL
        $this->fastapiUrl = env('API_URL', 'http://127.0.0.1:8000');
    }
    public function index_(){
        $armsRecords = [ [ "id"=> 753, "applicant_id"=> 75481, "cnic"=> "8130104129327", "name"=> "OMAR IBN ABDUL AZIZ CHAUDHAREY", "license_no"=> "202504780385460", "weapon_no"=> "T0620-25DK00247", "request_type"=> "New", "action"=> "Need approval", "operator"=> "Zulkifal", "file_status"=> "Pending", "url"=> "https://admin-icta.nitb.gov.pk/arm/applicant/75481/application/edit/85460", "created_at"=> "2025-04-28T15:12:31", "updated_at"=> null ], ["id"=> 752, "applicant_id"=> 75481, "cnic"=> "8130104129327", "name"=> "OMAR IBN ABDUL AZIZ CHAUDHAREY", "license_no"=> "202504780385460", "weapon_no"=> "T0620-25DK00247", "request_type"=> "New", "action"=> "Need approval", "operator"=> "Zulkifal", "file_status"=> "Pending", "url"=> "https://admin-icta.nitb.gov.pk/arm/applicant/75481/application/edit/85460", "created_at"=> "2025-04-28T15=>12=>31", "updated_at"=> null ]];
        return view('arms.index', compact('armsRecords'));
    }
    public function index__(Request $request)
    {
        // $dates = collect();

        // for ($i = 0; $i < 9; $i++) {
        //     $dates->push(Carbon::today()->subDays($i)->toDateString()); // Format: 'YYYY-MM-DD'
        // }

        // $keyword = $request->query('keyword', '');
        $response = Http::get("{$this->fastapiUrl}/arms");

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch records'], 500);
        }
        
        $data = $response->json();
        $armsRecords = $data['data'] ?? [];
        // return $armsRecords;
        return view('arms.index', compact('armsRecords', 'dates'));
    }
    public function index(Request $request)
    {
        
        $query = ArmsLicense::with('user');
        if ($request->keyword){
            $query->where('cnic', $request->keyword);
        }
        if ($request->issue_date){
            $query->where('issue_date', $request->issue_date);
        }
        $armsRecords = $query->paginate(25);
        
        return view('arms.index', compact('armsRecords'));
    }

    public function approve($id)
    {
        $response = Http::timeout(120)->post("{$this->fastapiUrl}/arms/approve/{$id}");
        if ($response->failed()) {
            return back()->withErrors(['Failed to fetch records']);
        }
        return redirect()->route('arms.index');
    }

    public function approveall()
    {
        $response = Http::timeout(300)->post("{$this->fastapiUrl}/arms/approve-all");
        if ($response->failed()) {
            return back()->withErrors(['Failed to fetch records']);
        }
        return redirect()->route('arms.index');

    }
    public function trash($id)
    {
        $response = Http::timeout(90)->post("{$this->fastapiUrl}/arms/trash/{$id}");
        if ($response->failed()) {
            return back()->withErrors(['Failed to fetch records']);
        }
        return redirect()->route('arms.index');
    }
    public function trashall()
    {
        $response = Http::timeout(300)->post("{$this->fastapiUrl}/arms/trash-all");
        if ($response->failed()) {
            return back()->withErrors(['Failed to fetch records']);
        }
        return redirect()->route('arms.index');
    }
    public function deliver($id)
    {
        $response = Http::post("{$this->fastapiUrl}/arms/deliver/{$id}");
        if ($response->failed()) {
            return back()->withErrors(['Failed to fetch records']);
        }
        return redirect()->route('arms.index');
    }
    public function pdf_report(Request $request)
    {
        $date1 = Carbon::parse($request->input('report_date1'))->startOfDay();
        $date2 = Carbon::parse($request->input('report_date2'))->endOfDay();

        $data = ArmsApproval::where('file_status', 'Approved')
        ->whereBetween('updated_at', [$date1, $date2])
        ->get();
        
        $pdf = Pdf::loadView('arms.pdf', [
            'reportDate1' => $date1->format('d M Y'),
            'reportDate2' => $date2->format('d M Y'),
            'data' => $data,
        ]);

    return $pdf->download("report_{$date1->format('dmY')}.pdf");


    }
    public function edit($id){
        $armsLicense=ArmsLicense::findOrFail($id);
        return view('arms.edit', compact('armsLicense'));
    }
    public function update(Request $request, $id)
    {
        $user_id = Auth::id();
        $validated = $request->validate([
            'approver_id' => 'nullable|integer',
            'character_certificate' => 'nullable|in:0,1',
            'address_on_cnic' => 'nullable|in:0,1',
            'affidavit' => 'nullable|in:0,1',
            'status_id' => 'nullable|in:0,1',
        ]);

        $armsLicense = ArmsLicense::findOrFail($id);

        $armsLicense->update([
            'approver_id' => $validated['approver_id'] ?? $armsLicense->approver_id,
            'character_certificate' => $validated['character_certificate'] ?? $armsLicense->character_certificate,
            'address_on_cnic' => $validated['address_on_cnic'] ?? $armsLicense->address_on_cnic,
            'affidavit' => $validated['affidavit'] ?? $armsLicense->affidavit,
            'updated_by' => $user_id,
            'status_id' => $validated['status_id'] ?? $armsLicense->status_id,
        ]);

        return redirect()->route('arms.index')
                        ->with('success', 'Record updated successfully.');
    }


}