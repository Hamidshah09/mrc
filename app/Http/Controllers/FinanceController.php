<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!empty($request->search)) { 
            $query = Finance::orderByDesc('id');
            if($request->search_type=='dated'){
                $query->where('dated', $request->search); 
            }elseif($request->search_type=='id'){
                $query->where('id', $request->search);
            }
            $finance_data = $query->paginate(25);
                        
        }else{
            $finance_data = Finance::orderBy('id', 'desc')->paginate(25);
        }
        
        if ($finance_data->count() > 0) {
            $last_balance = $finance_data->first()->balance; // safer & cleaner
        } else {
            $last_balance = 0;
        }
        
        return view('finance.index', compact('finance_data', 'last_balance'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
            'previous_balance' => 'required|integer|min:0',
            'expense' => 'required|integer|min:0',
            'income' => 'required|integer|min:0',
            'description'=>'required|max:100',
            'dated' => 'required|date|unique:finance,dated',
        ]);

        // Calculate balance
        $validated['balance'] = $validated['previous_balance'] + $validated['income'] - $validated['expense'];

        // Store in database
        $finance = \App\Models\Finance::create($validated);

        return redirect()->back()->with('success', 'Finance record added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $finance_data = Finance::findOrFail($id);
        $report_date = Carbon::parse($finance_data->dated);
        $pdf = Pdf::loadView('finance.pdf', [
            'finance_data' => $finance_data,
            'report_date' => $report_date,
        ]);
        return $pdf->download("Finance_Report_{$finance_data->dated}.pdf");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $finance = \App\Models\Finance::findOrFail($id);

        // Validate input
        $validated = $request->validate([
            'previous_balance' => 'required|integer|min:0',
            'expense' => 'required|integer|min:0',
            'income' => 'required|integer|min:0',
            'description'=>'required|max:100',
            'dated' => 'required|date|unique:finance,dated,' . $finance->id,
        ]);

        // Recalculate balance
        $validated['balance'] = $validated['previous_balance'] + $validated['income'] - $validated['expense'];

        // Update record
        $finance->update($validated);

        return redirect()->back()->with('success', 'Finance record updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
