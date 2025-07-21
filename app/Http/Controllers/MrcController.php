<?php

namespace App\Http\Controllers;

use App\Models\Mrc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MrcController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = MRC::with(['registrar', 'verifier']);

        if ($user->role === 'registrar') {
            $query->where('registrar_id', $user->id);
        }

        $mrcRecords = $query->paginate(10);

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

        ]);
        $validated['registrar_id'] = Auth::id(); // Assuming the registrar is the currently authenticated user
        $validated['status'] = 'pending';
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
        ]);
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
}
