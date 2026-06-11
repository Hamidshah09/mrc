<?php

namespace App\Http\Controllers;
use Illuminate\Http\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SuretyRegister;
use App\Models\SuretyHistory;
use App\Models\SuretyType;
use App\Models\SuretyStatus;
use App\Models\SuretyDocument;
use App\Models\PoliceStation;
use App\Models\SubDivision;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuretyController extends Controller
{
    public function index(Request $request)
    {
        $query = SuretyRegister::with(['suretyType', 'suretyStatus', 'policeStation']);

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($wr) use ($q) {
                $wr->where('id', 'like', "%{$q}%")
                    ->orWhere('guarantor_name', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('surety_status_id', $request->status);
        }

        if ($request->filled('surety_type_id')) {
            $query->where('surety_type_id', $request->surety_type_id);
        }

        if ($request->filled('from')) {
            $query->whereDate('receiving_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('receiving_date', '<=', $request->to);
        }

        $records = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        $suretyTypes = SuretyType::all();
        $surityStatuses = SuretyStatus::all();
        return view('surety.index', compact('records', 'surityStatuses', 'suretyTypes'));
    }

    public function create()
    {
 
        $suretyTypes = SuretyType::all();
        $policeStations = PoliceStation::all();
        $courts = SubDivision::all();
        $banks = DB::table('banks')->get();

        return view('surety.create', compact(
            'suretyTypes',
            'policeStations',
            'courts',
            'banks',
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guarantor_name' => 'required|string|max:80',
            'mobile_no' => 'required|string|max:13',
            'receiving_date' => 'nullable|date',
            'police_station_id' => 'required|integer',
            'section_of_law' => 'required|string|max:50',
            'accused_name' => 'required|string|max:80',
            'amount' => 'required|integer',
            'surety_type_id' => 'required|integer',
            'guarantor_cnic' => 'nullable|string|max:13',
            'guarantor_father_name' => 'nullable|string|max:80',
            'court_id' => 'nullable|integer',
            'payment_mode' => 'nullable|in:pay order,deposited in bank',
            'po_no' => 'nullable|string|max:50',
            'bank_id' => 'nullable|integer',
            'branch_name' => 'nullable|string|max:100',
            'checque_no' => 'nullable|string|max:50',
            'docs' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);


        // ✅ Create record
        $data = $request->only([
            'guarantor_name',
            'mobile_no',
            'receiving_date',
            'releasing_date',
            'police_station_id',
            'section_of_law',
            'accused_name',
            'amount',
            'surety_type_id',
            'surety_status_id',
            'document_id',
            'guarantor_cnic',
            'guarantor_father_name',
            'court_id',
            'payment_mode',
            'po_no',
            'bank_id',
            'branch_name',
            'checque_no'
        ]);
        $data['receiving_date'] = $data['receiving_date'] ?? now()->format('Y-m-d');
        $data['surety_status_id'] = 1; // default Received
        $data['user_id'] = auth()->id();
        $data['releasing_date'] = null;

        // Sanitize date fields to prevent invalid MySQL DATE values (e.g. malformed years)
        $dateKeys = ['receiving_date', 'releasing_date'];
        foreach ($dateKeys as $key) {
            if (!array_key_exists($key, $data)) {
                continue;
            }

            // preserve explicit nulls for releasing_date
            if ($key === 'releasing_date' && $data[$key] === null) {
                continue;
            }

            if (empty($data[$key])) {
                // default receiving_date to today if empty
                if ($key === 'receiving_date') {
                    $data[$key] = now()->format('Y-m-d');
                }
                continue;
            }

            try {
                $dt = Carbon::parse($data[$key]);
                $year = (int) $dt->format('Y');

                // MySQL DATE supports years up to 9999 — clamp to today if out of range
                if ($year < 1000 || $year > 9999) {
                    $data[$key] = now()->format('Y-m-d');
                } else {
                    $data[$key] = $dt->format('Y-m-d');
                }
            } catch (\Throwable $e) {
                // on parse error, fallback to today's date for receiving_date, otherwise null
                $data[$key] = $key === 'receiving_date' ? now()->format('Y-m-d') : null;
            }
        }

        // Handle optional uploaded payorder image/pdf
        if ($request->hasFile('docs')) {
            $path = $request->file('docs')->store('surety_docs', 'public');
            $data['docs'] = $path;
        }

        $surety = SuretyRegister::create($data);
        SuretyHistory::create([
            'surety_id' => $surety->id,
            'status_id' => 1, // "Received"
            'updated_by' => auth()->id(),
        ]);

        

            return redirect()->route('surety.index')->with('success', 'Surety record created successfully.');
    }


    public function edit($id)
    {
        $record = SuretyRegister::findOrFail($id);
        $surityStatuses = SuretyStatus::all();
        $suretyTypes = SuretyType::all();
        $policeStations = PoliceStation::all();
        $courts = SubDivision::all();
        $banks = DB::table('banks')->get();
        return view('surety.edit', compact('record', 'surityStatuses', 'suretyTypes', 'policeStations', 'courts', 'banks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'register_id' => 'nullable|integer',
            'guarantor_name' => 'required|string|max:80',
            'mobile_no' => 'required|string|max:13',
            'receipt_no' => 'nullable|string|max:50',
            'police_station_id' => 'required|integer',
            'section_of_law' => 'required|string|max:50',
            'accused_name' => 'required|string|max:80',
            'amount' => 'required|integer',
            'surety_type_id' => 'required|integer',
            'surety_status_id' => 'required|integer',
            'guarantor_cnic' => 'nullable|string|max:13',
            'guarantor_father_name' => 'nullable|string|max:80',
            'court_id' => 'nullable|integer',
            'payment_mode' => 'nullable|in:pay order,deposited in bank',
            'po_no' => 'nullable|string|max:50',
            'bank_id' => 'nullable|integer',
            'branch_name' => 'nullable|string|max:100',
            'checque_no' => 'nullable|string|max:50',
            'docs' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $record = SuretyRegister::findOrFail($id);

        $data = $request->only([
            'register_id',
            'guarantor_name',
            'mobile_no',
            'receipt_no',
            'releasing_date',
            'police_station_id',
            'section_of_law',
            'accused_name',
            'amount',
            'surety_type_id',
            'surety_status_id',
            'user_id',
            'document_id',
            'guarantor_cnic',
            'guarantor_father_name',
            'court_id',
            'payment_mode',
            'po_no',
            'bank_id',
            'branch_name',
            'checque_no'
        ]);

        // Handle docs replacement
        if ($request->hasFile('docs')) {
            // delete existing
            if ($record->docs) {
                Storage::disk('public')->delete($record->docs);
            }
            $path = $request->file('docs')->store('surety_docs', 'public');
            $data['docs'] = $path;
        }

        $record->update($data);

        SuretyHistory::create([
            'surety_id' => $record->id,
            'status_id' => $request->surety_status_id,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('surety.index')->with('success', 'Surety record updated successfully.');
    }

    public function updatestatus(Request $request, $id)
    {
        $request->validate([
            'surety_status_id' => 'required|integer',
                'releasing_date' => 'required|date',
        ]);

        $record = SuretyRegister::findOrFail($id);
        $record->update(['surety_status_id' => $request->surety_status_id, 'releasing_date' => $request->releasing_date]);

        $history = SuretyHistory::create([
            'surety_id' => $record->id,
            'status_id' => $request->surety_status_id,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('surety.index')->with('success', 'Surety status updated successfully.');
    }

    public function dashboard(Request $request)
    {
        
        // Default date range: use request values if provided, otherwise use min/max receiving_date from records
        $minDate = SuretyRegister::min('receiving_date');
        $maxDate = SuretyRegister::max('receiving_date');

        $start = Carbon::today('Asia/Karachi')->startOfDay()->utc();
        $end   = Carbon::today('Asia/Karachi')->endOfDay()->utc();

        $from = $request->input('from') ?? ($minDate ? Carbon::parse($minDate)->format('Y-m-d') : now()->subMonth()->format('Y-m-d'));
        $to = $request->input('to') ?? ($maxDate ? Carbon::parse($maxDate)->format('Y-m-d') : now()->format('Y-m-d'));
        $status = $request->input('status');

        // Ensure view variables are always defined to avoid "undefined variable" in blade
        $totalRecords_payorder = 0;
        $totalAmount_payorder = 0;
        $totalRecords_deposited = 0;
        $totalAmount_deposited = 0;

        $query = SuretyRegister::whereDate('receiving_date', '>=', $from)
            ->whereDate('receiving_date', '<=', $to);

        $totalRecords_payorder = (clone $query)->where('surety_status_id', 1)->where('payment_mode', 'pay order')->count();

        $totalAmount_payorder = (clone $query)->where('surety_status_id', 1)->where('payment_mode', 'pay order')->sum('amount');

        $totalRecords_deposited = (clone $query)->where('surety_status_id', 1)->where('payment_mode', 'deposited in bank')->count();

        $totalAmount_deposited = (clone $query)->where('surety_status_id', 1)->where('payment_mode', 'deposited in bank')->sum('amount');

        if ($status) {
            $query->where('surety_status_id', $status);
        }

        $typeCounts = (clone $query)
            ->select('surety_type_id', \DB::raw('count(*) as total'))
            ->groupBy('surety_type_id')
            ->get();

        $typeIds = $typeCounts->pluck('surety_type_id')->toArray();
        $typeNames = SuretyType::whereIn('id', $typeIds)->pluck('name', 'id')->toArray();

        $pieLabels = $typeCounts->map(function ($t) use ($typeNames) {
            return $typeNames[$t->surety_type_id] ?? $t->surety_type_id;
        })->toArray();
        $pieData = $typeCounts->pluck('total')->toArray();

        $daily = SuretyRegister::whereDate('receiving_date', '>=', $from)
            ->whereDate('receiving_date', '<=', $to)
            ->when($status, function ($q) use ($status) { return $q->where('surety_status_id', $status); })
            ->select(\DB::raw('DATE(receiving_date) as date'), \DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dailyLabels = $daily->pluck('date')->toArray();
        $dailyData = $daily->pluck('total')->toArray();

        $surityStatuses = SuretyStatus::all();

        // Removed user-performance calculations (user chart and table) per UI simplification


        $amountDaily = SuretyRegister::whereBetween('receiving_date', [$from, $to])
            ->select(DB::raw('DATE(receiving_date) as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $amountLabels = $amountDaily->pluck('date');
        $amountData = $amountDaily->pluck('total');

        return view('surety.dashboard', compact(
            'totalAmount_payorder',
            'totalAmount_deposited',
            'pieLabels',
            'pieData',
            'dailyLabels',
            'dailyData',
            'from',
            'to',
            'status',
            'surityStatuses',
            'totalRecords_payorder',
            'totalRecords_deposited',
            'amountLabels',
            'amountData'
        ));
    }

    public function show($id)
    {
        $record = SuretyRegister::with(['suretyType', 'suretyStatus', 'policeStation'])->findOrFail($id);

        $history = SuretyHistory::with(['status', 'updatedBy'])
            ->where('surety_id', $record->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $statuses = SuretyStatus::pluck('status_name', 'id');

        return view('surety.show', compact('record', 'history', 'statuses'));
    }
    /**
     * Render a printable report for a surety record. Add `?pdf=1` to stream as PDF when dompdf is available.
     */
    public function report(Request $request, $id)
    {
        $record = SuretyRegister::with(['suretyType', 'suretyStatus', 'policeStation', 'user', 'subDivision', 'bank'])->findOrFail($id);
        return $record;
        // If PDF requested and dompdf is available, stream PDF
        if ($request->query('pdf')) {
            try {
                $pdf = \PDF::loadView('surety.report', compact('record'))
                    ->setPaper('A4', 'portrait');
                return $pdf->stream('receipt_'.$record->id.'.pdf');
            } catch (\Throwable $e) {
                // fall back to HTML view if PDF generation fails
            }
        }

        return view('surety.report', compact('record'));
    }
    public function fetchByRegisterId($register_id)
    {
        $record = DB::table('suretyregisterold')->where('register_id', $register_id)->first();

        if (!$record) {
            return response()->json(['found' => false]);
        }

        return response()->json([
            'found' => true,
            'data' => $record
        ]);
    }
    public function searchAjax(Request $request)
    {
        \Log::info('Surety Search Request', [
            'search' => $request->search,
            'document_id' => $request->document_id
        ]);
        $query = SuretyRegister::with([
            'suretyStatus'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Search Only Receipt Number
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $query->where(
                'receipt_no',
                'like',
                '%' . trim($request->search) . '%'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Current Document Filter
        |--------------------------------------------------------------------------
        */

        // if ($request->filled('document_id')) {

        //     $query->where(
        //         'document_id',
        //         $request->document_id
        //     );
        // }

        /*
        |--------------------------------------------------------------------------
        | Get Records
        |--------------------------------------------------------------------------
        */

        $records = $query
            ->latest()
            ->get();

        \Log::info('Surety Search', [
            'search' => $request->search,
            'document_id' => $request->document_id,
            'results' => $records->count()
        ]);
        \Log::info('Search Results Count', [
            'count' => $records->count(),
            'records' => $records->pluck('receipt_no')
        ]);
        return response()->json([
            'success' => true,
            'records' => $records
        ]);
    }

    public function release($id)
    {
        $record = SuretyRegister::findOrFail($id);

        if ($record->surety_status_id == 2) {

            return response()->json([
                'success' => false,
                'message' => 'Already released'
            ], 422);
        }

        $record->update([
            'surety_status_id' => 2,
            'releasing_date'=>now()->format('Y-m-d'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Document Progress
        |--------------------------------------------------------------------------
        */

        $document = SuretyDocument::find(
            $record->document_id
        );

        $entered =
            SuretyRegister::where(
                'document_id',
                $record->document_id
            )->count();

        $document->update([
            'entered_entries' => $entered
        ]);

        return response()->json([

            'success' => true,

            'message' =>
                'Record released successfully',

            'entered' =>
                $document->entered_entries,

            'total' =>
                $document->total_expected_entries
        ]);
    }
    public function updateview($id)
    {
         $doc = SuretyDocument::findOrFail($id);

        // امنیت: only locker can access
        if ($doc->locked_by !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if ($doc->status == 'completed') {
            return redirect()->route('suretydocuments.index')->with('error', 'This document is already completed.');
        }   
      
        return view('surety.update', compact('doc'));
    }
}
