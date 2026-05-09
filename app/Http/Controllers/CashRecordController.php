<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CashRecord;
use Carbon\Carbon;

class CashRecordController extends Controller
{
    public function index()
    {
        $query = CashRecord::query();

        if(request('from')){
            $query->whereDate('date', '>=', request('from'));
        }

        if(request('to')){
            $query->whereDate('date', '<=', request('to'));
        }

        if(request('service_type')){
            $query->where('service_type', request('service_type'));
        }

        if(request('q')){
            $q = request('q');
            $query->where(function($qbuilder) use ($q){
                $qbuilder->where('name', 'like', "%{$q}%")
                    ->orWhere('cnic', 'like', "%{$q}%")
                    ->orWhere('mobile', 'like', "%{$q}%");
            });
        }

        $cashRecords = $query->orderBy('date', 'desc')->paginate(25);

        return view('cash-records.index', compact('cashRecords'));
    }

    public function create()
    {
        return view('cash-records.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'nullable|date',
            'cnic' => 'nullable|string|max:20',
            'name' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:50',
            'service_type' => 'nullable|in:online,offline',
            'request_type' => 'nullable|string|max:255',
            'domicile_number' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:100',
            'operator_name' => 'nullable|string|max:255',
        ]);

        CashRecord::create($data);

        return redirect()->route('cash-records.index')->with('success', 'Cash record created.');
    }

    public function edit($id)
    {
        $record = CashRecord::findOrFail($id);
        return view('cash-records.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $record = CashRecord::findOrFail($id);

        $data = $request->validate([
            'date' => 'nullable|date',
            'cnic' => 'nullable|string|max:20',
            'name' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:50',
            'service_type' => 'nullable|in:online,offline',
            'request_type' => 'nullable|string|max:255',
            'domicile_number' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:100',
            'operator_name' => 'nullable|string|max:255',
        ]);

        $record->update($data);

        return redirect()->route('cash-records.index')->with('success', 'Cash record updated.');
    }

    public function noteSheet(Request $request)
    {
        $query = CashRecord::query();

        // support single date or from/to range
        if ($request->filled('date')) {
            $query->whereDate('date', $request->input('date'));
            $challanDate = $request->input('date');
        } else {
            if ($request->filled('from')) {
                $query->whereDate('date', '>=', $request->input('from'));
            }
            if ($request->filled('to')) {
                $query->whereDate('date', '<=', $request->input('to'));
            }
            $challanDate = $request->input('from') && $request->input('to')
                ? $request->input('from') . ' to ' . $request->input('to')
                : ($request->input('from') ?? ($request->input('to') ?? date('Y-m-d')));
        }

        if ($request->filled('service_type')) {
            $query->where('service_type', $request->input('service_type'));
        }

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($qb) use ($q) {
                $qb->where('name', 'like', "%{$q}%")
                    ->orWhere('cnic', 'like', "%{$q}%")
                    ->orWhere('mobile', 'like', "%{$q}%");
            });
        }

        $cashRecords = $query
    ->orderBy('date', 'desc')
    ->get()
    ->unique('cnic')
    ->values();

        $title = 'Note Sheet for ' . $challanDate;

        $pdf = Pdf::loadView('cash-records.reports.note-sheet', compact('cashRecords', 'title'));

        return $pdf->stream('note-sheet.pdf');
    }

    public function challan(Request $request)
    {
        $query = CashRecord::query();

        // apply same filters as index
        if ($request->filled('date')) {
            $query->whereDate('date', $request->input('date'));
            $challanDate = $request->input('date');
        } else {
            if ($request->filled('from')) {
                $query->whereDate('date', '>=', $request->input('from'));
            }
            if ($request->filled('to')) {
                $query->whereDate('date', '<=', $request->input('to'));
            }
            $challanDate = $request->input('from') && $request->input('to')
                ? $request->input('from') . ' to ' . $request->input('to')
                : ($request->input('from') ?? ($request->input('to') ?? date('Y-m-d')));
        }

        if ($request->filled('service_type')) {
            $query->where('service_type', $request->input('service_type'));
        }

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($qb) use ($q) {
                $qb->where('name', 'like', "%{$q}%")
                    ->orWhere('cnic', 'like', "%{$q}%")
                    ->orWhere('mobile', 'like', "%{$q}%");
            });
        }

        $count = $query->distinct('cnic')->count('cnic');
        $feePerRecord = 200;
        $amount = $count * $feePerRecord;

        // amount in words using NumberFormatter
        $formatter = null;
        $amount_words = '';
        if (class_exists('\NumberFormatter')) {
            try {
                $formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
                $amount_words = ucfirst($formatter->format($amount)) . ' only';
            } catch (\Throwable $e) {
                $amount_words = (string) $amount;
            }
        } else {
            $amount_words = (string) $amount;
        }
        $pdf = Pdf::loadView('cash-records.reports.challan', compact('challanDate','amount', 'amount_words'));

        return $pdf->stream('challan.pdf');
    }


    
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $rows = Excel::toArray([], $request->file('file'));

        $data = $rows[0];

        // Remove header row
        unset($data[0]);

        foreach ($data as $row) {

            // Skip completely empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            $date = null;

            // Convert string date: 07/05/2026
            if (!empty($row[0])) {
                try {
                    $date = Carbon::createFromFormat('d/m/Y', trim($row[0]))
                        ->format('Y-m-d');
                } catch (\Exception $e) {
                    $date = null;
                }
            }

            CashRecord::create([

                'date' => $date,

                'name' => $row[1] ?? null,

                // Remove leading apostrophe from CNIC
                'cnic' => isset($row[2])
                    ? str_replace("'", '', trim($row[2]))
                    : null,

                'mobile' => $row[3] ?? null,

                'service_type' => isset($row[4])
                    ? trim(str_replace('(Physical Visit)', '', $row[4]))
                    : null,

                'request_type' => $row[6] ?? null,

                'domicile_number' => $row[7] ?? null,

                'status' => $row[9] ?? null,

                'operator_name' => $row[10] ?? null,
            ]);
        }

        return back()->with('success', 'Records imported successfully.');
    }
}
