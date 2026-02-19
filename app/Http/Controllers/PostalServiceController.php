<?php

namespace App\Http\Controllers;

use App\Models\PostalService;
use App\Models\PostalStatuses;
use App\Models\City;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostalServiceController extends Controller
{
    /**
     * Show the form for creating a new postal service record
     */
    public function create()
    {
        $statuses = PostalStatuses::all();
        $services = Services::all();
        $cities = City::all();
        return view('postalservice.create', compact('statuses', 'services', 'cities'));
    }

    /**
     * Store a newly created postal service record in the database
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'receiver_name' => 'required|string|max:255',
            'receiver_address' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'receiver_city_id' => 'required|exists:cities,id',
            'service_id' => 'required|exists:services,id',
        ]);

        // Add the authenticated user's ID;
        $validated['status_id'] = 1; // Default status (e.g., "In Transit")
        $validated['weight'] = '20';
        $validated['rate'] = 160;
        // Create the record
        $record = PostalService::create($validated);
        \App\Models\PostalHistory::create([
            'postalservice_id' => $record->id,
            'status_id' => 1,
            'user_id' => null,
        ]);

        return redirect()->route('postalservice.create')->with('success', 'Postal service record created successfully.');
    }

    /**
     * Display all postal service records
     */
    public function index(Request $request)
    {
        $query = PostalService::with('status');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $searchType = $request->search_type ?? 'article_number';

            if ($searchType === 'article_number') {
                $query->where('article_number', 'like', '%' . $search . '%');
            } elseif ($searchType === 'receiver_name') {
                $query->where('receiver_name', 'like', '%' . $search . '%');
            } elseif ($searchType === 'receiver_address') {
                $query->where('receiver_address', 'like', '%' . $search . '%');
            } elseif ($searchType === 'phone_number') {
                $query->where('phone_number', 'like', '%' . $search . '%');
            }
        }

        // Date range filter
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        // Status filter
        if ($request->filled('status')) {
            $statusId = PostalStatuses::where('status', 'like', $request->status)->first();
            if ($statusId) {
                $query->where('status_id', $statusId->id);
            }
        }

        // Paginate the results
        $query->orderBy('id', 'desc');
        $records = $query->paginate(10);
        $user = Auth::user();
        $statuses = PostalStatuses::all();
        $services = Services::all();
        return view('postalservice.index', compact('records', 'user', 'statuses', 'services'));
    }

    /**
     * Display a single postal service record
     */
    public function show($id)
    {
        $record = PostalService::with('status', 'history', 'history.user')->findOrFail($id);
        
        // Check if user is authorized to view (optional: only owner or admin)
        // You can add authorization logic here if needed

        return view('postalservice.show', compact('record'));
    }

    /**
     * Show the form for editing a postal service record
     */
    public function edit($id)
    {
        $record = PostalService::findOrFail($id);
        $statuses = PostalStatuses::all();
        $services = Services::all();
        $cities = City::all();

        return view('postalservice.edit', compact('record', 'statuses', 'services', 'cities'));
    }

    /**
     * Update a postal service record in the database
     */
    public function update(Request $request, $id)
    {
        $record = PostalService::findOrFail($id);
        

        // Validate the incoming data
        $validated = $request->validate([
            'article_number' => 'nullable|string|max:255',
            'receiver_name' => 'required|string|max:255',
            'receiver_address' => 'required|string|max:255',
            'receiver_city_id' => 'required|exists:cities,id',
            'phone_number' => 'nullable|string|max:15',
            'weight' => 'required|string|max:20',
            'rate' => 'required|integer',
            'service_id' => 'required|exists:services,id',
            'status_id' => 'required|exists:postalstatuses,id',
        ]);

        // Update the record
        $record->update($validated);
        $services = Services::all();
        $cities = City::all();
        return redirect()->route('postalservice.index', compact('services', 'cities'))->with('success', 'Postal service record updated successfully.');
    }

    /**
     * Update the status of a postal service record and log to PostalHistory
     */
    public function updateStatus(Request $request, $id)
    {
        $record = PostalService::findOrFail($id);

        // Validate the incoming data
        $validated = $request->validate([
            'status_id' => 'required|exists:postalstatuses,id',
        ], [
            'status_id.exists' => 'The selected status is invalid.',
        ]);

        // Check if status is actually changing
        if ($record->status_id == $validated['status_id']) {
            return redirect()->route('postalservice.index')->with('warning', 'No status change made.');
        }

        // Update the record's status
        $record->update(['status_id' => $validated['status_id'], 'user_id' => Auth::id()]);

        // Log the status change to PostalHistory
        \App\Models\PostalHistory::create([
            'postalservice_id' => $id,
            'status_id' => $validated['status_id'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('postalservice.index')->with('success', 'Postal service status updated successfully.');
    }
    public function getPakistanPostTracking(Request $request)
    {
        $trackingId = $request->query('trackingId');

        if (!$trackingId) {
            return response()->json([
                'success' => false,
                'error' => 'trackingId parameter is missing'
            ], 422);
        }

        $url = "https://ep.gov.pk/emtts/EPTrack_Live.aspx?ArticleIDz=" . urlencode($trackingId);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT      => "Mozilla/5.0",
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_SSL_VERIFYPEER => false, // IMPORTANT for local dev
        ]);

        $html = curl_exec($ch);

        if (curl_errno($ch)) {
            return response()->json([
                'success' => false,
                'error' => curl_error($ch)
            ], 500);
        }

        curl_close($ch);

        if (!$html) {
            return response()->json([
                'success' => false,
                'error' => 'Empty response from Pakistan Post'
            ], 500);
        }

        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);

        $data = [
            'tracking_id'     => trim($xpath->evaluate("string(//span[@id='LblArticleTrackingNo'])")),
            'booking_office'  => trim($xpath->evaluate("string(//span[@id='LblBookingOffice'])")),
            'delivery_office' => trim($xpath->evaluate("string(//span[@id='LblDeliveryOffice'])")),
            'events'          => []
        ];

        $rows = $xpath->query("//div[@id='TrackDetailDiv']//table//tr");

        $currentDate = null;

        foreach ($rows as $row) {
            $dateNode = $xpath->query(".//div[contains(@class,'date-heading')]", $row);
            if ($dateNode->length > 0) {
                $currentDate = trim($dateNode->item(0)->textContent);
                continue;
            }

            $cells = $row->getElementsByTagName("td");
            if ($cells->length === 4) {
                $data['events'][] = [
                    'date'     => $currentDate,
                    'time'     => trim($cells->item(1)->textContent),
                    'location' => trim($cells->item(2)->textContent),
                    'status'   => trim($cells->item(3)->textContent),
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

}
