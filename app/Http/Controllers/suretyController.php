<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SuretyRegister;
use App\Models\SuretyHistory;
use App\Models\SuretyType;
use App\Models\SuretyStatus;
use App\Models\SuretyDocument;
use App\Models\PoliceStation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class suretyController extends Controller
{
    public function index(Request $request)
    {
        $query = SuretyRegister::with(['suretyType', 'suretyStatus', 'policeStation']);

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($wr) use ($q) {
                $wr->where('register_id', 'like', "%{$q}%")
                   ->orWhere('guarantor_name', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('surety_status_id', $request->status);
        }

        if ($request->filled('police_station_id')) {
            $query->where('police_station_id', $request->police_station_id);
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

        $records = $query->orderBy('register_id', 'desc')->paginate(15)->withQueryString();

        $policeStations = PoliceStation::all();
        $suretyTypes = SuretyType::all();
        $surityStatuses = SuretyStatus::all();
        return view('surety.index', compact('records', 'surityStatuses', 'policeStations', 'suretyTypes'));
    }

    public function create($id)
    {
         $doc = SuretyDocument::findOrFail($id);

        // امنیت: only locker can access
        if ($doc->locked_by !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if ($doc->status == 'completed') {
            return redirect()->route('suretydocuments.index')->with('error', 'This document is already completed.');
        }   
        $suretyTypes = SuretyType::all();
        $policeStations = PoliceStation::all();
        return view('surety.create', compact('suretyTypes', 'policeStations', 'doc'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'register_id' => 'required|integer|unique:suretyregister,register_id',
            'guarantor_name' => 'required|string|max:80',
            'mobile_no' => 'required|string|max:15',
            'receipt_no' => 'required|string|max:50',
            'receiving_date' => 'required|date',
            'police_station_id' => 'required|integer',
            'section_of_law' => 'required|string|max:50',
            'accused_name' => 'required|string|max:80',
            'amount' => 'required|integer',
            'surety_type_id' => 'required|integer',
            'document_id' => 'required|exists:suretydocuments,id',
        ]);

        // 🔒 Ensure document is locked by current user
        $doc = SuretyDocument::findOrFail($request->document_id);

        if ($doc->locked_by !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // ✅ Create record
        $surety = SuretyRegister::create([
            'register_id' => $request->register_id,
            'guarantor_name' => $request->guarantor_name,
            'mobile_no' => $request->mobile_no,
            'receipt_no' => $request->receipt_no,
            'receiving_date' => $request->receiving_date,
            'releasing_date' => null, // hidden field
            'police_station_id' => $request->police_station_id,
            'section_of_law' => $request->section_of_law,
            'accused_name' => $request->accused_name,
            'amount' => $request->amount,
            'surety_type_id' => $request->surety_type_id,
            'surety_status_id' => 1, // default "Received"
            'user_id' => auth()->id(),
            'document_id' => $request->document_id,
        ]);
        SuretyHistory::create([
            'surety_id' => $surety->id,
            'status_id' => 1, // "Received"
            'updated_by' => auth()->id(),
        ]);

        // 📊 Update progress
        $doc->increment('entered_entries');

        // ✅ Auto-complete document (smart behavior)
        if ($doc->total_expected_entries &&
            $doc->entered_entries >= $doc->total_expected_entries) {

            $totalAmount = SuretyRegister::where('document_id', $doc->id)
            ->sum('amount');

        if ($doc->total_amount != $totalAmount) {

            $doc->update([
                'status' => 'audit failed'
            ]);

            return response()->json([
                'success' => true,
                'entered' => $doc->entered_entries,
                'total' => $doc->total_expected_entries,
                'audit' => 'failed',
                'message' => 'Amount mismatch detected'
            ]);
        }

        // ✅ If correct
        $doc->update([
            'status' => 'completed',
            'locked_by' => null,
            'locked_at' => null,
        ]);


        }

        return response()->json([
            'success' => true,
            'entered' => $doc->entered_entries,
            'total' => $doc->total_expected_entries
        ]);
    }

    public function edit($id)
    {
        $record = SuretyRegister::findOrFail($id);
        $surityStatuses = SuretyStatus::all();
        $suretyTypes = SuretyType::all();
        $policeStations = PoliceStation::all();
        return view('surety.edit', compact('record', 'surityStatuses', 'suretyTypes', 'policeStations'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'register_id' => 'required|integer',
            'guarantor_name' => 'required|string|max:80',
            'mobile_no' => 'required|string|max:15',
            'receipt_no' => 'required|string|max:50',
            'receiving_date' => 'required|date',
            'police_station_id' => 'required|integer',
            'section_of_law' => 'required|string|max:50',
            'accused_name' => 'required|string|max:80',
            'amount' => 'required|integer',
            'surety_type_id' => 'required|integer',
            'surety_status_id' => 'required|integer',
        ]);
        $record = SuretyRegister::findOrFail($id);
        $record->update($request->all());
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

        $from = $request->input('from') ?? ($minDate ? Carbon::parse($minDate)->format('Y-m-d') : now()->subMonth()->format('Y-m-d'));
        $to = $request->input('to') ?? ($maxDate ? Carbon::parse($maxDate)->format('Y-m-d') : now()->format('Y-m-d'));
        $status = $request->input('status');

        $query = SuretyRegister::whereDate('receiving_date', '>=', $from)
            ->whereDate('receiving_date', '<=', $to);

        $totalRecords = (clone $query)->count();

        $totalAmount = (clone $query)->sum('amount');

        $todayCount = SuretyRegister::whereDate('receiving_date', today())->count();

        $completedCount = SuretyRegister::where('surety_status_id', 2)->count(); // adjust ID
        
        if ($status) {
            $query->where('surety_status_id', $status);
        }

        $typeCounts = (clone $query)
            ->select('surety_type_id', \DB::raw('count(*) as total'))
            ->groupBy('surety_type_id')
            ->get();

        // For debugging: get matched records and total
        $matchedRecords = (clone $query)->get();
        $totalRecords = SuretyRegister::count();
        $firstRecord = SuretyRegister::first();

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

        // User performance: count of history actions by user within date range (and optional status)
      
        $start = Carbon::today('Asia/Karachi')->startOfDay()->utc();
        $end   = Carbon::today('Asia/Karachi')->endOfDay()->utc();

        $userCounts = SuretyRegister::whereBetween('receiving_date', [$from, $to])
            ->select('user_id', DB::raw('count(*) as total'))
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->get();

        $userIds = $userCounts->pluck('user_id');

        $userNames = User::whereIn('id', $userIds)
            ->pluck('name', 'id');

        $userLabels = $userCounts->map(fn($u) =>
            $userNames[$u->user_id] ?? 'User '.$u->user_id
        );

        $userData = $userCounts->pluck('total');


        $amountDaily = SuretyRegister::whereBetween('receiving_date', [$from, $to])
            ->select(DB::raw('DATE(receiving_date) as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $amountLabels = $amountDaily->pluck('date');
        $amountData = $amountDaily->pluck('total');

        return view('surety.dashboard', compact('totalAmount', 'pieLabels', 'pieData', 
                                                'dailyLabels', 'dailyData', 'from', 'to', 'status',
                                                 'surityStatuses', 'userLabels', 'userData', 
                                                 'matchedRecords', 'totalRecords', 'firstRecord', 'amountLabels', 'amountData', 'todayCount', 'completedCount'));
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
}
