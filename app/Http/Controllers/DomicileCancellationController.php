<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DomicileCancellation;
use App\Models\DispatchDiary;

class DomicileCancellationController extends Controller
{
    public function create(){
        return view('cancellation.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'CNIC' => 'required|string|max:13',
            'Applicant_Name' => 'required|string|max:70',
            'Relation' => 'required|string|max:5',
            'Applicant_FName' => 'required|string|max:70',
            'Address' => 'required|string|max:200',
            'Domicile_No' => 'required|string|max:20',
            'Domicile_Date' => 'required|date',
            'Remarks' => 'nullable|string|max:45',
        ]);

        DomicileCancellation::create($validated);

        return redirect()->route('domicile.cancellation.index')->with('success', 'Domicile cancellation record created successfully.');
    }
    public function index(Request $request){
        $query = DomicileCancellation::with('dispatchDiary')->orderBy('Letter_ID','desc');
        // Apply search filter based on search_type
        if ($request->filled('search') && $request->filled('search_type')) {
            $search = $request->search;
            $searchType = $request->search_type;

            switch ($searchType) {
                case 'cnic':
                    $query->where('CNIC', 'like', '%' . $search . '%');
                    break;
                case 'name':
                    $query->where('Applicant_Name', 'like', '%' . $search . '%');
                    break;
                case 'id':
                    $query->where('Letter_ID', 'like', '%' . $search . '%');
                    break;
                case 'dispatch_no':
                    $query->whereHas('dispatchDiary', function ($q) use ($search) {
                        $q->where('Dispatch_No', 'like', '%' . $search . '%');
                    });
                    break;
            }
        }

        // Apply date range filter
        if ($request->filled('from_date')) {
            $query->where('Letter_Date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->where('Letter_Date', '<=', $request->to_date);
        }

        // Paginate and append query params for filter persistence
        $letters = $query->paginate(10)->appends($request->query());
        return view('cancellation.index', compact('letters'));
    }
    public function edit($id){
        $letter = DomicileCancellation::findOrFail($id);
        return view('cancellation.edit', compact('letter'));
    }
    public function update(Request $request, $id){
        $validated = $request->validate([
            'CNIC' => 'required|string|max:13',
            'Applicant_Name' => 'required|string|max:70',
            'Relation' => 'required|string|max:5',
            'Applicant_FName' => 'required|string|max:70',
            'Address' => 'required|string|max:200',
            'Domicile_No' => 'required|string|max:20',
            'Domicile_Date' => 'required|date',
            'Remarks' => 'nullable|string|max:45',
        ]);

        $cancellation = DomicileCancellation::findOrFail($id);
        $cancellation->update($validated);

        return redirect()->route('domicile.cancellation.index')->with('success', 'Domicile cancellation record updated successfully.');
    }
    public function issueletter($id){
        $letter = DomicileCancellation::findOrFail($id);
        $pdf = \PDF::loadView('cancellation.letter', compact('letter'));
        return $pdf->stream('domicile_cancellation_letter.pdf');
    }
}
