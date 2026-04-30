<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseRegister;
use Illuminate\Support\Facades\DB;

class ExpenseRegisterController extends Controller
{
    public function create(Request $request)
    {
        $accountheads = [
            (object) ['name' => 'A01156 - Pay of Staff'],
            (object) ['name' => 'A03901 - Stationary'],
            (object) ['name' => 'A03955 - Computer Stationary'],
            (object) ['name' => 'A03970 - Others'],
            (object) ['name' => 'A03303 - Electricity'],
            (object) ['name' => 'A03302 - Telephone'],
            (object) ['name' => 'A03827 - POL'],
            (object) ['name' => 'A09203 - IT Equipment (Purchase)'],
            (object) ['name' => 'A09601 - Machinery (Purchase)'],
            (object) ['name' => 'A09701 - Furniture & Fixture'],
            (object) ['name' => 'A13701 - Hardware (Repair)'],
            (object) ['name' => 'A3301 - Repair of Building'],
            (object) ['name' => 'A13101 - Repair of  Machinery'],
            (object) ['name' => 'A13001 - Repair of  Transport'],
            (object) ['name' => 'A09601-Purchase of Plant and Machinery'],
        ];
        if ($request->has('month') && $request->has('year')) {
            $recentEntries = ExpenseRegister::where('month', $request->query('month'))
                ->where('year', $request->query('year'))
                ->latest()
                ->take(50)
                ->get();
        } else {
            $recentEntries = ExpenseRegister::latest()->take(50)->get();
        }

        return view('ExpensesRegister.create', compact('accountheads', 'recentEntries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_head' => 'required|string',
            'amount' => 'required|numeric',
            'month' => 'required|string',
            'year' => 'required|string',
        ]);

        \App\Models\ExpenseRegister::create($request->all());

        return redirect()->route('expense_register.create', $request->only(['month', 'year']))->with('success', 'Expense registered successfully.');
    }

    public function index(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');

        $query = ExpenseRegister::query();
        if ($month) {
            $query->where('month', $month);
        }
        if ($year) {
            $query->where('year', $year);
        }

        $summary = $query->select('account_head', DB::raw('SUM(amount) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('account_head')
            ->orderByDesc('total')
            ->get();

        $grandTotal = $summary->sum('total');

        $months = [
            'January','February','March','April','May','June','July','August','September','October','November','December'
        ];

        $years = ExpenseRegister::select('year')->distinct()->orderByDesc('year')->pluck('year')->toArray();

        return view('ExpensesRegister.index', compact('summary', 'month', 'year', 'grandTotal', 'months', 'years'));
    }

    public function edit($id)
    {
        $entry = ExpenseRegister::findOrFail($id);

        $accountheads = [
            (object) ['name' => 'A01156 - Pay of Staff'],
            (object) ['name' => 'A03901 - Stationary'],
            (object) ['name' => 'A03955 - Computer Stationary'],
            (object) ['name' => 'A03970 - Others'],
            (object) ['name' => 'A03303 - Electricity'],
            (object) ['name' => 'A03302 - Telephone'],
            (object) ['name' => 'A03827 - POL'],
            (object) ['name' => 'A09203 - IT Equipment (Purchase)'],
            (object) ['name' => 'A09601 - Machinery (Purchase)'],
            (object) ['name' => 'A09701 - Furniture & Fixture'],
            (object) ['name' => 'A13701 - Hardware (Repair)'],
            (object) ['name' => 'A3301 - Repair of Building'],
            (object) ['name' => 'A13101 - Repair of  Machinery'],
        ];

        return view('ExpensesRegister.edit', compact('entry', 'accountheads'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'account_head' => 'required|string',
            'amount' => 'required|numeric',
            'month' => 'required|string',
            'year' => 'required|string',
        ]);

        $entry = ExpenseRegister::findOrFail($id);
        $entry->update($request->only(['account_head', 'amount', 'month', 'year']));

        return redirect()->route('expense_register.create')->with('success', 'Expense updated successfully.');
    }

    
}
