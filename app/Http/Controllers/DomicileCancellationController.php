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
            'Father_Name' => 'required|string|max:70',
            'Address' => 'required|string|max:200',
            'Domicile_No' => 'required|string|max:20',
            'Domicile_Date' => 'required|date',
            'Remarks' => 'nullable|string|max:45',
        ]);

        $record = DomicileCancellation::create($validated);
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
            'Letter_Type' => 'Cancellation Letter',
            'Letter_ID' => $record->Letter_ID,
        ]);

        return redirect()->route('domicile.cancellation.index')->with('success', 'Domicile cancellation record created successfully.');
    }
    public function index(Request $request)
    {
        $query = DomicileCancellation::with(
            'dispatchDiary'
        )->orderBy(
            'Letter_ID',
            'desc'
        );

        /*
        |--------------------------------------------------------------------------
        | Universal Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );

            $query->where(function ($q) use ($search) {

                // Letter ID
                $q->where(
                    'Letter_ID',
                    'like',
                    "%{$search}%"
                )

                // CNIC
                ->orWhere(
                    'CNIC',
                    'like',
                    "%{$search}%"
                )

                // Applicant Name
                ->orWhere(
                    'Applicant_Name',
                    'like',
                    "%{$search}%"
                )

                // Domicile Number
                ->orWhere(
                    'Domicile_No',
                    'like',
                    "%{$search}%"
                )

                // Dispatch Number
                ->orWhereHas(
                    'dispatchDiary',
                    function ($sub) use ($search) {

                        $sub->where(
                            'Dispatch_No',
                            'like',
                            "%{$search}%"
                        );
                    }
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Date Filters
        |--------------------------------------------------------------------------
        */

        if ($request->filled('from_date')) {

            $query->whereDate(
                'Letter_Date',
                '>=',
                $request->from_date
            );
        }

        if ($request->filled('to_date')) {

            $query->whereDate(
                'Letter_Date',
                '<=',
                $request->to_date
            );
        }

        $letters = $query
            ->paginate(10)
            ->appends(
                $request->query()
            );

        return view(
            'cancellation.index',
            compact('letters')
        );
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
            'Father_Name' => 'required|string|max:70',
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
        // get current error
        $year = date('Y');
        $pdf = \PDF::loadView('cancellation.letter', compact('letter', 'year'));
        return $pdf->stream('domicile_cancellation_letter.pdf');
    }
}
