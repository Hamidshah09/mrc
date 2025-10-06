<?php

namespace App\Http\Controllers;

use App\Models\Centers;
use App\Models\CenterServices;
use App\Models\Services;
use App\Models\Statistics;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {   
        $center_services = Centers::with('services')->get();

        $startDate = Carbon::now()->subDays(9)->startOfDay(); // 10 days including today
        $endDate = Carbon::now()->endOfDay();

        $statistics = Statistics::with(['center:id,location', 'service:id,service'])
            ->whereBetween('report_date', [$startDate, $endDate])
            ->get();

        // Group by date → then by center → then by service
        $grouped = $statistics->groupBy('report_date');

        // Build header structure: centers and their services
        $centers = $statistics->groupBy(fn($stat) => $stat->center->location)
            ->map(function ($stats, $location) {
                return [
                    'location' => $location,
                    'services' => $stats->pluck('service')->unique('id')->values(),
                ];
            });

        // Build rows: one per date
        $reportRows = $grouped->map(function ($dayStats, $date) use ($centers) {
            $row = ['date' => $date];
            foreach ($centers as $center) {
                foreach ($center['services'] as $service) {
                    $stat = $dayStats->first(fn($s) =>
                        $s->center->location === $center['location'] &&
                        $s->service->id === $service->id
                    );
                    $row[] = $stat ? $stat->service_count : 0;
                }
            }
            return $row;
        })->values();
        
        return view('statistics.index', compact('center_services','centers', 'reportRows'));
    }
    public function pdf_report(Request $request)
    {
        $reportDate = Carbon::parse(request('report_date') ?? now()->toDateString());

        $stats = Statistics::with(['center:id,location', 'service:id,service'])
            ->whereDate('report_date', $reportDate)
            ->get();

        // Get unique services and centers
        $services = $stats->pluck('service')->unique('id')->values();
        $centers = $stats->pluck('center')->unique('id')->values();

        // Build matrix: rows = services, columns = centers
        $reportMatrix = $services->map(function ($service) use ($centers, $stats) {
            $row = ['service_name' => $service->service];
            foreach ($centers as $center) {
                $stat = $stats->first(fn($s) =>
                    $s->center_id === $center->id &&
                    $s->service_id === $service->id
                );
                $row[$center->location] = $stat ? $stat->service_count : '-';
            }
            return $row;
        });
        // Load the Blade view and generate PDF
        $pdf = Pdf::loadView('statistics.pdf', [
            'reportDate' => $reportDate->format('d M Y'),
            'centers' => $centers,
            'reportMatrix' => $reportMatrix,
        ]);

    return $pdf->download("report_{$reportDate->format('Ymd')}.pdf");
    }
    public function store(Request $request)
    {
        // ✅ Validate the inputs
        $validated = $request->validate([
            'center_id' => 'required|integer|exists:centers,id',
            'report_date' => 'required|date',
            'services' => 'required|array',
            'services.*' => 'nullable|integer|min:0', // counts
        ]);

        // ✅ Loop through each service entry and store it
        foreach ($validated['services'] as $serviceId => $count) {
            // Skip empty or zero counts if desired
            if ($count === null || $count === '') {
                continue;
            }

            Statistics::updateOrCreate(
                [
                    'center_id' => $validated['center_id'],
                    'service_id' => $serviceId,
                    'report_date' => $validated['report_date'],
                ],
                ['service_count' => $count]
            );

        }

        return redirect()
            ->back()
            ->with('success', 'Daily report created successfully!');
    }
    public function upsert(Request $request)
    {
        $validated = $request->validate([
            'center_id' => 'required|integer',
            'service_id' => 'required|integer',
            'report_date' => 'required|date',
            'service_count' => 'required|integer|min:0',
        ]);

        $stat = Statistics::updateOrCreate(
            [
                'center_id' => $validated['center_id'],
                'service_id' => $validated['service_id'],
                'report_date' => $validated['report_date'],
            ],
            ['service_count' => $validated['service_count']]
        );

        return redirect()->back()->with('success', 'Report saved successfully.');
    }

}
