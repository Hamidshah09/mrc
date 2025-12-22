<?php

namespace App\Http\Controllers;

use App\Models\AuqafOfficial;
use App\Models\Mousque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuqafOfficialsController extends Controller
{
    public function create()
    {
        $positions = [
            1 => 'Khateeb',
            2 => 'Moazzin',
            3 => 'Khadim',
        ];

        $mousques = Mousque::with('sector')->get();
        return view('auqaf.officials.create', compact('positions', 'mousques'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'           => 'required|string|max:255',
            'father_name'    => 'required|string|max:255',
            'position'       => 'required|in:1,2,3',
            'contact_number' => 'required|string|max:15',
            'cnic'           => 'required|string|unique:auqaf_officials,cnic',
            'type'           => 'required|in:Regular,Shrine,Private',
            'profile_image'  => 'nullable|image|max:2048',
            'mousque_id'     => 'nullable|exists:mousques,id',
        ]);

        /* ---------- Handle Profile Image Upload ---------- */
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')
                            ->store('auqaf_officials', 'public');

            $validatedData['profile_image'] = $path;
        }

        AuqafOfficial::create($validatedData);

        return redirect()
            ->route('auqaf-officials.index')
            ->with('success', 'Auqaf Official created successfully.');
    }

    public function edit($id)
    {
        $auqafOfficial = AuqafOfficial::findOrFail($id);
        $positions = [
            1 => 'Khateeb',
            2 => 'Moazzin',
            3 => 'Khadim',
        ];
        $mousques = Mousque::with('sector')->get();
        return view('auqaf.officials.edit', compact('auqafOfficial', 'positions', 'mousques'));
    }
    

    public function update(Request $request, AuqafOfficial $auqafOfficial)
    {
        $validatedData = $request->validate([
            'name'           => 'required|string|max:255',
            'father_name'    => 'required|string|max:255',
            'position'       => 'required|in:1,2,3',
            'contact_number' => 'required|string|max:15',
            'cnic'           => 'required|string|unique:auqaf_officials,cnic,' . $auqafOfficial->id,
            'type'           => 'required|in:Regular,Shrine,Private',
            'profile_image'  => 'nullable|image|max:2048',
            'mousque_id'     => 'nullable|exists:mousques,id',
        ]);

        /* ---------- Handle Profile Image Update ---------- */
        if ($request->hasFile('profile_image')) {

            // Delete old image if exists
            if ($auqafOfficial->profile_image &&
                Storage::disk('public')->exists($auqafOfficial->profile_image)) {

                Storage::disk('public')->delete($auqafOfficial->profile_image);
            }

            // Store new image
            $path = $request->file('profile_image')
                            ->store('auqaf_officials', 'public');

            $validatedData['profile_image'] = $path;
        }

        $auqafOfficial->update($validatedData);

        return redirect()
            ->route('auqaf-officials.index')
            ->with('success', 'Auqaf Official updated successfully.');
    }

}
