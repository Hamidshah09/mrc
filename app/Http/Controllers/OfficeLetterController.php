<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfficeLetter;
use App\Models\DispatchDiary;
class OfficeLetterController extends Controller
{
    public function index(Request $request)
    {
        $letters = OfficeLetter::with('dispatchDiary')->orderBy('id', 'desc');

        if ($request->has('search') && $request->input('search') !== '') {
            $letters->where(function ($query) use ($request) {
                $query->where('subject', 'like', '%' . $request->input('search') . '%')
                      ->orWhere('letter_to', 'like', '%' . $request->input('search') . '%')
                        ->orWhereHas('dispatchDiary', function ($q) use ($request) {
                            $q->where('Dispatch_No', 'like', '%' . $request->input('search') . '%');
                        });
            });
        }

        if ($request->filled('from_date')) {
            $letters->whereDate('letter_date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $letters->whereDate('letter_date', '<=', $request->input('to_date'));
        }

        $letters = $letters->paginate(10)->appends($request->except('page'));
        
        return view('office-letters.index', compact('letters'));
    }

    public function create()
    {
        return view('office-letters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'letter_date' => 'required|date',
            'letter_to' => 'required|string|max:80',
            'subject' => 'required|string|max:100',
        ]);

        $officeletter = OfficeLetter::create([
            'letter_date' => $request->input('letter_date'),
            'letter_to' => $request->input('letter_to'),
            'subject' => $request->input('subject'),
        ]);

        //inserting dispatch diary record
        $lastDispatch = DispatchDiary::latest('Dispatch_ID')->first();

        $currentYear = now()->year;

        if (!$lastDispatch || $lastDispatch->timestamp->year != $currentYear) {
            $dispatchNo = 1;
        } else {
            $dispatchNo = $lastDispatch->Dispatch_No + 1;
        }

        DispatchDiary::create([
            'Dispatch_No' => $dispatchNo,
            'Letter_Type' => 'Office Letter',
            'Letter_ID' => $officeletter->id,
        ]);

        return redirect()->route('domicile.office_letters.index')->with('success', 'Office letter created successfully.');
    }

    public function edit($id)
    {
        $letter = OfficeLetter::findOrFail($id);
        return view('office-letters.edit', compact('letter'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'letter_date' => 'required|date',
            'letter_to' => 'required|string|max:80',
            'subject' => 'required|string|max:100',
        ]);

        $letter = OfficeLetter::findOrFail($id);
        $letter->update([
            'letter_date' => $request->input('letter_date'),
            'letter_to' => $request->input('letter_to'),
            'subject' => $request->input('subject'),
        ]);

        return redirect()->route('domicile.office_letters.index')->with('success', 'Office letter updated successfully.');
    }

}
