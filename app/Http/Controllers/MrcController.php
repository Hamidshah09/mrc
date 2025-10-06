<?php

namespace App\Http\Controllers;

use App\Models\Mrc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Imports\MrcImport;
use App\Models\MrcStatus;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class MrcController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = MRC::with(['registrar', 'verifier'])->orderBy('id', 'desc');

        // Limit to registrar's own records if applicable
    if ($user->role === 'registrar') {
        $query->where('registrar_id', $user->id);
    }

    // Apply search filters
    if ($request->filled('search') && $request->filled('search_type')) {
        $searchType = $request->input('search_type');
        $searchValue = $request->input('search');

        // Sanitize and apply search type filter
        if (in_array($searchType, ['groom_cnic', 'groom_name', 'bride_cnic', 'bride_name'])) {
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
    if ($request->filled('status') && in_array($request->input('status'), ['verified', 'not verified'])) {
        $query->where('status', $request->input('status'));
    }

    // Get filtered results
    $mrcRecords = $query->paginate(10)->withQueryString(); // keep filters in pagination links

    return view('mrc.index', compact('mrcRecords', 'user'));
    }
    public function create()
    {
        return view('mrc.create');
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
            'image'              => 'required|image|mimes:jpg,jpeg,png|max:4048',

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

        Mrc::create($validated);

        return redirect()->route('dashboard')->with('success', 'MRC record created successfully.');
    }
    public function show($id){
        $record = Mrc::findorfail($id);
        return $record;
    }
    public function edit($id)
    {
        $mrc = Mrc::findOrFail($id);
        return view('mrc.edit', compact('mrc'));
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
            'image'              => 'nullable|image|mimes:jpg,jpeg,png|max:4048',
            
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

        return redirect()->route('dashboard')->with('success', 'MRC record updated successfully.');
    }
    public function verify(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to verify MRC records.');
        }
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

        return redirect()->route('dashboard')->with('success', 'MRC record verified successfully.');
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
