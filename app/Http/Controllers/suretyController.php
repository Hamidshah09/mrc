<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SuretyRegister;
use App\Models\SuretyHistory;
use App\Models\SuretyType;
use App\Models\SuretyStatus;
use App\Models\PoliceStation;
use App\Models\User;

class suretyController extends Controller
{
    public function index(Request $request)
    {
        $query = SuretyRegister::with(['suretyType', 'suretyStatus', 'policeStation']);

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($wr) use ($q) {
                $wr->where('register_id', 'like', "%{$q}%")
                   ->orWhere('guarantaor_name', 'like', "%{$q}%");
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
            $query->whereDate('receipt_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('receipt_date', '<=', $request->to);
        }

        $records = $query->orderBy('register_id', 'desc')->paginate(15)->withQueryString();

        $surityStatuses = SuretyStatus::all();
        $policeStations = PoliceStation::all();
        $suretyTypes = SuretyType::all();

        return view('surety.index', compact('records', 'surityStatuses', 'policeStations', 'suretyTypes'));
    }

    public function create()
    {
        $suretyTypes = SuretyType::all();
        $surityStatuses = SuretyStatus::all();
        $policeStations = PoliceStation::all();
        return view('surety.create', compact('surityStatuses', 'suretyTypes', 'policeStations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'register_id' => 'required|integer',
            'guarantaor_name' => 'required|string|max:80',
            'mobile_no' => 'required|string|max:15',
            'receipt_no' => 'required|string|max:50',
            'receipt_date' => 'required|date',
            'police_station_id' => 'required|integer',
            'section_of_law' => 'required|string|max:50',
            'accused_name' => 'required|string|max:80',
            'amount' => 'required|integer',
            'surety_type_id' => 'required|integer',
            'surety_status_id' => 'required|integer',
        ]);
        SuretyRegister::create($request->all());
        SuretyHistory::create([
            'surety_id' => $request->register_id,
            'status_id' => $request->surety_status_id,
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
        return view('surety.edit', compact('record', 'surityStatuses', 'suretyTypes', 'policeStations'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'register_id' => 'required|integer',
            'guarantaor_name' => 'required|string|max:80',
            'mobile_no' => 'required|string|max:15',
            'receipt_no' => 'required|string|max:50',
            'receipt_date' => 'required|date',
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
            'surety_id' => $record->register_id,
            'status_id' => $request->surety_status_id,
            'updated_by' => auth()->id(),
        ]);
        return redirect()->route('surety.index')->with('success', 'Surety record updated successfully.');
    }

    public function updatestatus(Request $request, $id)
    {
        $request->validate([
            'surety_status_id' => 'required|integer',
                'manual_date' => 'required|date',
        ]);

        $record = SuretyRegister::findOrFail($id);
        $record->update(['surety_status_id' => $request->surety_status_id]);

        $history = SuretyHistory::create([
            'surety_id' => $record->register_id,
            'status_id' => $request->surety_status_id,
            'updated_by' => auth()->id(),
        ]);

            $manual = Carbon::parse($request->input('manual_date'));
            $history->created_at = $manual;
            $history->updated_at = $manual;
            $history->save();

        return redirect()->route('surety.index')->with('success', 'Surety status updated successfully.');
    }

    public function dashboard(Request $request)
    {
        // Default date range: use request values if provided, otherwise use min/max receipt_date from records
        $minDate = SuretyRegister::min('receipt_date');
        $maxDate = SuretyRegister::max('receipt_date');

        $from = $request->input('from') ?? ($minDate ? Carbon::parse($minDate)->format('Y-m-d') : now()->subMonth()->format('Y-m-d'));
        $to = $request->input('to') ?? ($maxDate ? Carbon::parse($maxDate)->format('Y-m-d') : now()->format('Y-m-d'));
        $status = $request->input('status');

        $query = SuretyRegister::whereDate('receipt_date', '>=', $from)
            ->whereDate('receipt_date', '<=', $to);

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

        $daily = SuretyRegister::whereDate('receipt_date', '>=', $from)
            ->whereDate('receipt_date', '<=', $to)
            ->when($status, function ($q) use ($status) { return $q->where('surety_status_id', $status); })
            ->select(\DB::raw('DATE(receipt_date) as date'), \DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dailyLabels = $daily->pluck('date')->toArray();
        $dailyData = $daily->pluck('total')->toArray();

        $surityStatuses = SuretyStatus::all();

        // User performance: count of history actions by user within date range (and optional status)
      
        $start = Carbon::today('Asia/Karachi')->startOfDay()->utc();
        $end   = Carbon::today('Asia/Karachi')->endOfDay()->utc();

        $userCounts = SuretyHistory::whereBetween('created_at', [$start, $end])
            ->whereNotNull('updated_by')
            ->select('updated_by', \DB::raw('count(*) as total'))
            ->groupBy('updated_by')
            ->orderByDesc('total')
            ->get();

        $userIds = $userCounts->pluck('updated_by')->toArray();
        $userNames = User::whereIn('id', $userIds)->pluck('name', 'id')->toArray();

        $userLabels = $userCounts->map(function ($u) use ($userNames) {
            return $userNames[$u->updated_by] ?? ('User '.$u->updated_by);
        })->toArray();

        $userData = $userCounts->pluck('total')->toArray();

        return view('surety.dashboard', compact('pieLabels', 'pieData', 'dailyLabels', 'dailyData', 'from', 'to', 'status', 'surityStatuses', 'userLabels', 'userData', 'matchedRecords', 'totalRecords', 'firstRecord'));
    }

    public function show($id)
    {
        $record = SuretyRegister::with(['suretyType', 'suretyStatus', 'policeStation'])->findOrFail($id);

        $history = SuretyHistory::with(['status', 'updatedBy'])
            ->where('surety_id', $record->register_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $statuses = SuretyStatus::pluck('status_name', 'id');

        return view('surety.show', compact('record', 'history', 'statuses'));
    }
}
