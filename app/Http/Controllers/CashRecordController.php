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

        if(request('payment_type')){
            $query->where('payment_type', request('payment_type'));
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
    public function monthlyReport(Request $request)
    {
        $query = CashRecord::query();

        /*
        |--------------------------------------------------------------------------
        | Date Range Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('from')) {

            $query->whereDate(
                'date',
                '>=',
                $request->from
            );
        }

        if ($request->filled('to')) {

            $query->whereDate(
                'date',
                '<=',
                $request->to
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Service Type Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('service_type')) {

            $query->where(
                'service_type',
                $request->service_type
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Payment Type Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('payment_type')) {

            $query->where(
                'payment_type',
                $request->payment_type
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Search Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('q')) {

            $q = $request->q;

            $query->where(function ($qb) use ($q) {

                $qb->where(
                        'name',
                        'like',
                        "%{$q}%"
                    )
                    ->orWhere(
                        'cnic',
                        'like',
                        "%{$q}%"
                    )
                    ->orWhere(
                        'mobile',
                        'like',
                        "%{$q}%"
                    );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Get Records
        |--------------------------------------------------------------------------
        */

        $cashRecords = $query
            ->select('cashrecords.*')
            ->distinct('cnic')
            ->orderBy('date', 'desc')
            ->get()
            ->unique('cnic')
            ->values();
        /*
        |--------------------------------------------------------------------------
        | Totals
        |--------------------------------------------------------------------------
        */

        $count = $cashRecords->count();

        $amount = $count * 200;

        /*
        |--------------------------------------------------------------------------
        | Report Period
        |--------------------------------------------------------------------------
        */

        $reportPeriod = 'All Time';

        if (
            $request->filled('from') &&
            $request->filled('to')
        ) {

            $reportPeriod =
                Carbon::parse($request->from)
                    ->format('d M Y')
                .
                ' to '
                .
                Carbon::parse($request->to)
                    ->format('d M Y');

        } elseif ($request->filled('from')) {

            $reportPeriod =
                'From '
                .
                Carbon::parse($request->from)
                    ->format('d M Y');

        } elseif ($request->filled('to')) {

            $reportPeriod =
                'Up To '
                .
                Carbon::parse($request->to)
                    ->format('d M Y');
        }

        /*
        |--------------------------------------------------------------------------
        | Generate PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'cash-records.reports.monthly-report',
            compact(
                'cashRecords',
                'reportPeriod',
                'count',
                'amount'
            )
        );

        return $pdf->stream(
            'monthly-report.pdf'
        );
    }
    public function noteSheet(Request $request)
    {
        $request->validate([
            'from' => 'nullable|date|required_without:date',
            'to' => 'nullable|date|required_with:from',
        ], [
            'from.required_without' => 'Please select a date or date range.',
            'to.required_with' => 'Please select the ending date.',
        ]);

        $query = CashRecord::query();
        $challanDate = '';
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
                $challanDate = $request->input('from');
            }
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

        $title = $challanDate;

        $pdf = Pdf::loadView('cash-records.reports.note-sheet', compact('cashRecords', 'title'));

        return $pdf->stream('note-sheet.pdf');
    }

    public function challanSheet(Request $request)
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
                $challanDate = $request->input('to');
            }
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
        $amount = $query
                    ->orderBy('date', 'desc')
                    ->get()
                    ->unique('cnic')
                    ->values()
                    ->count() * 200;
        
        $title = $challanDate;

        $pdf = Pdf::loadView('cash-records.reports.challan-sheet', compact('cashRecords', 'title', 'amount'));

        return $pdf->stream('challan-sheet.pdf');
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

        //Check weather data is present or not for a specific date
        if (!empty($data[1][0])) {
            try {
                $reportdate = Carbon::createFromFormat('d/m/Y', trim($data[1][0]))
                    ->format('Y-m-d');
            } catch (\Exception $e) {
                $reportdate = null;
            }
        }

        if (isset($reportdate)) {
            $existingRecords = CashRecord::whereDate('date', $reportdate)->count();
            if ($existingRecords > 0) {
                return back()->with('error', "Records for date {$reportdate} already exist. Please remove existing records before uploading new data for the same date.");
            }
        }

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
                'payment_type' => $row[5] ?? null,

                'request_type' => $row[6] ?? null,

                'domicile_number' => $row[7] ?? null,

                'status' => $row[9] ?? null,

                'operator_name' => $row[10] ?? null,
            ]);
        }

        return back()->with('success', 'Records imported successfully.');
    }
}
