<?php

namespace App\Http\Controllers;

use App\Models\PostalService;
use App\Models\PostalStatuses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PostalServiceExportController extends Controller
{
    // ...existing code...

    public function exportPdf(Request $request)
    {
        $query = PostalService::query();

        // Apply filters (same as index)
        if ($request->filled('search')) {
            $search = $request->search;
            $searchType = $request->search_type ?? 'article_number';
            if ($searchType === 'article_number') {
                $query->where('article_number', 'like', "%$search%");
            } elseif ($searchType === 'receiver_name') {
                $query->where('receiver_name', 'like', "%$search%");
            } elseif ($searchType === 'receiver_address') {
                $query->where('receiver_address', 'like', "%$search%");
            } elseif ($searchType === 'phone_number') {
                $query->where('phone_number', 'like', "%$search%");
            }
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        if ($request->filled('status')) {
            $statusId = PostalStatuses::where('status', 'like', $request->status)->first();
            if ($statusId) {
                $query->where('status_id', $statusId->id);
            }
        }
        $records = $query->get();
        $totalRate = $records->sum('rate');
        $totalWeight = $records->sum('weight');
        $pdf = Pdf::loadView('postalservice.pdf', [
            'records' => $records,
            'totalRate' => $totalRate,
            'totalWeight' => $totalWeight,
        ]);
        return $pdf->download('postalservice_report.pdf');
    }

    public function exportPdfWithReceiving(Request $request)
    {
        $query = PostalService::query();

        // Apply filters (same as index)
        if ($request->filled('search')) {
            $search = $request->search;
            $searchType = $request->search_type ?? 'article_number';
            if ($searchType === 'article_number') {
                $query->where('article_number', 'like', "%$search%");
            } elseif ($searchType === 'receiver_name') {
                $query->where('receiver_name', 'like', "%$search%");
            } elseif ($searchType === 'receiver_address') {
                $query->where('receiver_address', 'like', "%$search%");
            } elseif ($searchType === 'phone_number') {
                $query->where('phone_number', 'like', "%$search%");
            }
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        if ($request->filled('status')) {
            $statusId = PostalStatuses::where('status', 'like', $request->status)->first();
            if ($statusId) {
                $query->where('status_id', $statusId->id);
            }
        }
        $records = $query->get();
        $totalRate = $records->sum('rate');
        $totalWeight = $records->sum('weight');
        $pdf = Pdf::loadView('postalservice.pdf_receiving', [
            'records' => $records,
            'totalRate' => $totalRate,
            'totalWeight' => $totalWeight,
        ]);
        return $pdf->download('postalservice_report_with_receiving.pdf');
    }
}
