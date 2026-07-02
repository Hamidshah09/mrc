<?php

namespace App\Http\Controllers;

use App\Models\Mrc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Imports\MrcImport;
use App\Models\MrcStatus;
use App\Models\UnionCouncil;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Carbon\Carbon;

class MrcController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Mrc::with(['user', 'unionCouncil'])->orderBy('id', 'desc');

        // Limit to registrar's own records if applicable

    // Apply search filters
    if ($request->filled('search') && $request->filled('search_type')) {
        $searchType = $request->input('search_type');
        $searchValue = $request->input('search');

        // Sanitize and apply search type filter
        if (in_array($searchType, ['groom_cnic', 'groom_name', 'bride_cnic', 'bride_name','registrar_name'])) {
            $query->where($searchType, 'LIKE', '%' . $searchValue . '%');
        }
    }

    // Date range filter
    if ($request->filled('From')) {
        $query->whereDate('created_at', '>=', $request->input('From'));
    }

    if ($request->filled('To')) {
        $query->whereDate('created_at', '<=', $request->input('To'));
    }

    // Status filter
    // if ($request->filled('status') && in_array($request->input('status'), ['verified', 'not verified'])) {
    //     $query->where('status', $request->input('status'));
    // }

    // Union council filter
    if ($request->filled('union_council_id')) {
        $query->where('union_council_id', $request->input('union_council_id'));
    }

    // Get filtered results
    $mrcRecords = $query->paginate(10)->withQueryString(); // keep filters in pagination links

    $unionCouncils = UnionCouncil::orderBy('name')->get();

    return view('mrc.index', compact('mrcRecords', 'user', 'unionCouncils'));
    }
    /**
     * Display MRC dashboard with charts and daily-per-user table.
     */
    public function dashboard(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $from = $request->input('from', $today);
        $to = $request->input('to', $today);
        $selectedUnionCouncil = $request->input('union_council_id', 'all');

        $query = Mrc::whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to);

        if ($selectedUnionCouncil !== 'all' && is_numeric($selectedUnionCouncil)) {
            $query->where('union_council_id', $selectedUnionCouncil);
        }

        $records = $query
            ->selectRaw('DATE(created_at) as date, registrar_id, union_council_id, count(*) as cnt')
            ->groupBy('date', 'registrar_id', 'union_council_id')
            ->orderBy('date')
            ->get();

        $period = [];
        $start = Carbon::parse($from);
        $end = Carbon::parse($to);
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $period[] = $d->toDateString();
        }

        $registrarIds = $records->pluck('registrar_id')->unique()->filter()->values()->all();
        $unionCouncilIds = $records->pluck('union_council_id')->unique()->filter()->values()->all();
        $users = User::whereIn('id', $registrarIds)->get()->keyBy('id');
        $unionCouncils = UnionCouncil::whereIn('id', $unionCouncilIds)->get()->keyBy('id');

        $totals = array_fill_keys($period, 0);
        $perUser = [];
        $userTotals = [];
        foreach ($records as $r) {
            $date = $r->date;
            $uid = $r->registrar_id ?: 0;
            $unionCouncilId = $r->union_council_id ?: 0;
            $userName = $users->has($uid) ? $users[$uid]->name : 'System';
            $unionCouncilName = $unionCouncils->has($unionCouncilId) ? $unionCouncils[$unionCouncilId]->name : 'N/A';
            $rowKey = $uid . '_' . $unionCouncilId;

            $totals[$date] = ($totals[$date] ?? 0) + $r->cnt;
            $perUser[$uid][$date] = ($perUser[$uid][$date] ?? 0) + $r->cnt;
            $userTotals[$rowKey] = [
                'user' => $userName,
                'union_council' => $unionCouncilName,
                'count' => ($userTotals[$rowKey]['count'] ?? 0) + $r->cnt,
            ];
        }

        $tableRows = array_values($userTotals);
        $totalCount = array_sum(array_column($tableRows, 'count'));

        $unionCouncils = UnionCouncil::orderBy('name')->get();

        $series = [];
        foreach ($perUser as $uid => $map) {
            $label = $users->has($uid) ? $users[$uid]->name : 'System';
            $data = [];
            foreach ($period as $d) {
                $data[] = $map[$d] ?? 0;
            }
            $series[] = ['label' => $label, 'data' => $data];
        }

        $totalValues = array_values($totals);

        return view('mrc.dashboard', compact('period', 'totalValues', 'series', 'tableRows', 'from', 'to', 'unionCouncils', 'selectedUnionCouncil', 'totalCount'));
    }
    public function create()
    {
        $unionCouncils = UnionCouncil::orderBy('name')->get();
        $last = session('last_union_council_id');
        return view('mrc.create', compact('unionCouncils', 'last'));
    }
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'groom_name'         => 'required|string|max:50',
            'bride_name'         => 'required|string|max:50',
            'groom_father_name'  => 'required|string|max:50',
            'bride_father_name'  => 'required|string|max:50',
            'groom_passport'     => 'nullable|string|max:10',
            'bride_passport'     => 'nullable|string|max:10',
            'groom_cnic'         => 'nullable|string|max:13',
            'bride_cnic'         => 'nullable|string|max:13',
            'marriage_date'      => 'required|date',
            'registration_date'  => 'required|date',
            'verifier_id'        => 'nullable|exists:users,id',
            'verification_date'  => 'nullable|date',
            'remarks'            => 'nullable|string|max:100',
            'register_no'        => 'nullable|string|max:20',
            'registrar_name'     => 'nullable|string|max:80',
            'image'              => 'nullable|image|mimes:jpg,jpeg,png|max:4048',
            'union_council_id'   => 'required|exists:union_councils,id',

        ]);
        $exist = Mrc::where('groom_cnic', $request->groom_cnic)->Where('bride_cnic', $request->bride_cnic)->first();
        if ($exist){
            return back()
        ->withErrors(['duplicate' => 'This Nikkah record already exists'])
        ->withInput();
        }
        $validated['registrar_id'] = Auth::id(); // Assuming the registrar is the currently authenticated user
        $validated['status'] = 'Pending';
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('mrc_images', 'public');
        }

        $mrc = Mrc::create($validated);

        // save last used union council in session for convenience
        if (!empty($validated['union_council_id'])) {
            session(['last_union_council_id' => $validated['union_council_id']]);
        }

        return redirect()->route('mrc.index')->with('success', 'MRC record created successfully.');
    }
    public function show($id){
        $record = Mrc::findorfail($id);
        return $record;
    }
    public function edit($id)
    {
        $mrc = Mrc::findOrFail($id);
        $unionCouncils = UnionCouncil::orderBy('name')->get();
        return view('mrc.edit', compact('mrc', 'unionCouncils'));
    }
    public function update(Request $request, $id)
    {
        $mrc = Mrc::findOrFail($id);

        $validated = $request->validate([
            'groom_name'         => 'required|string|max:50',
            'bride_name'         => 'required|string|max:50',
            'groom_father_name'  => 'required|string|max:50',
            'bride_father_name'  => 'required|string|max:50',
            'groom_passport'     => 'nullable|string|max:10',
            'bride_passport'     => 'nullable|string|max:10',
            'groom_cnic'         => 'nullable|string|max:13',
            'bride_cnic'         => 'nullable|string|max:13',
            'marriage_date'      => 'required|date',
            'registration_date'  => 'required|date',
            'remarks'            => 'nullable|string|max:100',
            'register_no'        => 'nullable|string|max:20',
            'registrar_name'     => 'nullable|string|max:80',
            'image'              => 'nullable|image|mimes:jpg,jpeg,png|max:4048',
            'union_council_id'   => 'required|exists:union_councils,id',
            
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($mrc->image && Storage::disk('public')->exists($mrc->image)) {
                Storage::disk('public')->delete($mrc->image);
            }

            // Store new image inside storage/app/public/mrc_images
            $validated['image'] = $request->file('image')->store('mrc_images', 'public');
        }


        $mrc->update($validated);

        // update last used union council in session
        if (!empty($validated['union_council_id'])) {
            session(['last_union_council_id' => $validated['union_council_id']]);
        }

        return redirect()->route('mrc.index')->with('success', 'MRC record updated successfully.');
    }
    public function verify(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role->role == 'admin' or $user->role->role == 'verifier') {
            $mrc = Mrc::findOrFail($id);
            $validated = $request->validate([
                'remarks' => 'nullable|string|max:100',
            ]);

            $mrc->update([
                'status' => 'Verified',
                'verifier_id' => $user->id,
                'verification_date' => now()->toDateString(),
                'remarks' => $validated['remarks'],
            ]);

            return redirect()->route('mrc.index')->with('success', 'MRC record verified successfully.');    
        }else{
            return redirect()->route('mrc.index')->with('error', 'You are not authorized to verify MRC records.');
        }
        
    }
    public function upload_(Request $request){
        return view('mrc.import');        
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);
        Excel::import(new MrcImport, $request->file('file'));

        return redirect()->back()->with('success', 'File imported successfully!');
    }
    public function check(Request $request)
    {
        $request->validate([
            'cnic' => 'required|string'
        ]);

        // Search for applicant in DB
        $status = MrcStatus::where('applicant_cnic', $request->cnic)->first();

        if ($status) {
            return redirect()->back()->with('status', [
                'tracking_id'      => $status->tracking_id,
                'certificate_type' => $status->certificate_type,
                'applicant_name'   => $status->applicant_name,
                'status'   => $status->status,
            ]);
        }

        return redirect()->back()->with('error', 'No record found for this CNIC.');
    }

}
