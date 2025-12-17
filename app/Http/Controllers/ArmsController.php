<?php

namespace App\Http\Controllers;

use App\Models\ArmsApproval;
use App\Models\ArmsHistory;
use App\Models\ArmsLicense;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $query = ArmsLicense::query()->with('user');

        // Keyword search
        if ($request->keyword !== null && $request->keyword !== '') {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('cnic', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->orWhere('license_number', 'LIKE', "%$keyword%")
                ->orWhere('weapon_number', 'LIKE', "%$keyword%");
            });
        }

        // Issue Date
        if ($request->issue_date !== null && $request->issue_date !== '') {
            $query->whereDate('issue_date', $request->issue_date);
        }

        // Approver ID
        if ($request->approver_id !== null && $request->approver_id !== '') {
            $query->where('approver_id', (int) $request->approver_id);
        }

        // Status ID
        if ($request->status_id !== null && $request->status_id !== '') {
            $query->where('status_id', (int) $request->status_id);
        }

        // Address on CNIC
        if ($request->address_on_cnic !== null && $request->address_on_cnic !== '') {
            $query->where('address_on_cnic', $request->address_on_cnic);
        }

        // Character Certificate
        if ($request->character_certificate !== null && $request->character_certificate !== '') {
            $query->where('character_certificate', $request->character_certificate);
        }

        // Affidavit
        if ($request->affidavit !== null && $request->affidavit !== '') {
            $query->where('affidavit', $request->affidavit);
        }

        // Called
        if ($request->called !== null && $request->called !== '') {
            $query->where('called', $request->called);
        }

        // Letter Issued
        if ($request->letter_issued !== null && $request->letter_issued !== '') {
            $query->where('letter_issued', $request->letter_issued);
        }

        // Pagination with appends
        $armsRecords = $query->paginate(25)->appends($request->all());

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
        $role = Auth::user()->role->role;
        $id = Auth::user()->id;
        $armsHistory = ArmsHistory::with('armsLicense', 'user')->where('arms_license_id', $id)->get();
        return view('arms.edit', compact('armsLicense', 'role', 'id', 'armsHistory'));
    }
    public function update(Request $request, $id)
    {
        $user_id = Auth::id();
        $validated = $request->validate([
            'address' => 'nullable|string',
            'approver_id' => 'nullable|integer',
            'character_certificate' => 'nullable|in:0,1',
            'address_on_cnic' => 'nullable|in:0,1',
            'affidavit' => 'nullable|in:0,1',
            'status_id' => 'nullable|in:0,1',
            'called' => 'nullable|in:1,2,3',
            'letter_issued' => 'nullable|in:0,1',
            'audit_result' => 'nullable|in:0,1',
        ]);

        $armsLicense = ArmsLicense::findOrFail($id);

        $armsLicense->update([
            'approver_id' => $validated['approver_id'] ?? $armsLicense->approver_id,
            'character_certificate' => $validated['character_certificate'] ?? $armsLicense->character_certificate,
            'address_on_cnic' => $validated['address_on_cnic'] ?? $armsLicense->address_on_cnic,
            'affidavit' => $validated['affidavit'] ?? $armsLicense->affidavit,
            'updated_by' => $user_id,
            'address' => $validated['address'] ?? $armsLicense->address,
            'status_id' => $validated['status_id'] ?? $armsLicense->status_id,
            'called' => $validated['called'] ?? $armsLicense->called,
            'audit_result' => $validated['audit_result'] ?? $armsLicense->audit_result,
            'letter_issued' => $validated['letter_issued'] ?? $armsLicense->letter_issued,
        ]);

        ArmsHistory::create([
            'arms_license_id' => $id,
            'user_id' => $user_id,
            'action' => 'Record Updated',
        ]);

        return redirect()->route('arms.index')
                        ->with('success', 'Record updated successfully.');
    }
    public function generateLetter($id)
    {
        $record = ArmsLicense::findOrFail($id);

        // Paragraph logic
        $paragraph = "Your arms license record has been scrutinized and it has been found that ";

        // Address issue
        if ($record->address_on_cnic === 0) {
            $paragraph .= "you are not a resident of Islamabad. Please explain within 15 days from the  date of issuance of this letter, as to why your license may not be cancelled for being a non-resident of Islamabad.";
        }

        // Character certificate issue
        if ($record->character_certificate === 0 and $record->address_on_cnic === 0) {
            $paragraph .= " Furthermore, your character certificate has not been provided. You are required to furnish a valid character certificate.";
        } else if ($record->character_certificate === 0) {
            $paragraph .= " Your character certificate has not been provided. You are required to furnish a valid character certificate within 15 days from the date of issuance of this letter to ovaid cancellation of license.";
        }

        // Pass variables to view
        $pdf = Pdf::loadView('arms.letter', [
            'record' => $record,
            'paragraph' => $paragraph
        ]);
        ArmsHistory::create([
            'arms_license_id' => $record->id,
            'user_id' => Auth::id(),
            'action' => 'Letter Generated',
        ]);
        $fileName = 'Letter_' . $record->name . '.pdf';
        $record->letter_issued = 1;
        $record->letter_issuance_date = now()->toDateString();
        $record->save();
        return $pdf->download($fileName);
    }
    public function statistics()
    {
        $totalLicenses = ArmsLicense::whereBetween('issue_date', ['2022-04-01', '2024-03-31'])->count();
        $totalAudited = ArmsLicense::where('status_id', 0)->orWhere('status_id', 1)->count();
        $percentAudited = $totalLicenses > 0 ? ($totalAudited / $totalLicenses) * 100 : 0;
        $percentAudited = round($percentAudited, 2);
        $approvedByDc = ArmsLicense::where('status_id', 1)->where('approver_id', 1)->count();
        $approvedByAdcg = ArmsLicense::where('status_id', 1)->where('approver_id', 2)->count();
        $noAddressByDc = ArmsLicense::where('status_id', 1)->where('approver_id', 1)->where('address_on_cnic', 0)->count();
        $noAddressByAdcg = ArmsLicense::where('status_id', 1)->where('approver_id', 2)->where('address_on_cnic', 0)->count();
        $nocharacterByDc = ArmsLicense::where('status_id', 1)->where('approver_id', 1)->where('character_certificate', 0)->count();
        $nocharacterByAdcg = ArmsLicense::where('status_id', 1)->where('approver_id', 2)->where('character_certificate', 0)->count();
        $notApproved = ArmsLicense::where('status_id', 0)->count();
        $monthlyApprovedByDc = DB::table('arms_licenses')
        ->selectRaw("YEAR(issue_date) AS year, MONTH(issue_date) AS month, DATE_FORMAT(issue_date, '%M') AS month_name, COUNT(*) AS total_approved")
        ->where('status_id', 1)
        ->where('approver_id', 1)
        ->groupByRaw("YEAR(issue_date), MONTH(issue_date), DATE_FORMAT(issue_date, '%M')")
        ->orderByRaw("YEAR(issue_date), MONTH(issue_date)")
        ->get();

        $monthlyApprovedByAdcg = DB::table('arms_licenses')
            ->selectRaw("YEAR(issue_date) AS year, MONTH(issue_date) AS month, DATE_FORMAT(issue_date, '%M') AS month_name, COUNT(*) AS total_approved")
            ->where('status_id', 1)
            ->where('approver_id', 2)
            ->groupByRaw("YEAR(issue_date), MONTH(issue_date), DATE_FORMAT(issue_date, '%M')")
            ->orderByRaw("YEAR(issue_date), MONTH(issue_date)")
            ->get();
        $monthlyissued = DB::table('arms_licenses')
            ->selectRaw("YEAR(issue_date) AS year, MONTH(issue_date) AS month, DATE_FORMAT(issue_date, '%M') AS month_name, COUNT(*) AS total_approved")
            ->whereBetween('issue_date', ['2022-04-01', '2025-11-30'])
            ->groupByRaw("YEAR(issue_date), MONTH(issue_date), DATE_FORMAT(issue_date, '%M')")
            ->orderByRaw("YEAR(issue_date), MONTH(issue_date)")
            ->get();
        $monthlyremaining = DB::table('arms_licenses')
            ->selectRaw("YEAR(issue_date) AS year, MONTH(issue_date) AS month, DATE_FORMAT(issue_date, '%M') AS month_name, COUNT(*) AS total_approved")
            ->whereNull('status_id')
            ->whereBetween('issue_date', ['2022-04-01', '2025-11-30'])
            ->groupByRaw("YEAR(issue_date), MONTH(issue_date), DATE_FORMAT(issue_date, '%M')")
            ->orderByRaw("YEAR(issue_date), MONTH(issue_date)")
            ->get();
        
        $dcApproved = $monthlyApprovedByDc->keyBy(fn ($i) => $i->year . '-' . $i->month);

        $adcgApproved = $monthlyApprovedByAdcg->keyBy(fn ($i) => $i->year . '-' . $i->month);

        $remainingLicenses = $monthlyremaining->keyBy(fn ($i) => $i->year . '-' . $i->month);

        // return $monthlyApproved;
        return view('arms.armstatistics', compact(
            'totalLicenses',
            'totalAudited',
            'percentAudited',
            'approvedByDc',
            'approvedByAdcg',
            'notApproved',
            'monthlyApprovedByDc',
            'monthlyApprovedByAdcg',
            'monthlyissued',
            'noAddressByDc',
            'noAddressByAdcg',
            'nocharacterByDc',
            'nocharacterByAdcg',
            'dcApproved',
            'adcgApproved',
            'remainingLicenses'
        ));
    }
    

}
