<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\SuretyDocument;

class SuretyDocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = SuretyDocument::with('locker');

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Entries filter
        if ($request->filled('entries_min')) {
            $query->where('entered_entries', '>=', $request->entries_min);
        }

        if ($request->filled('entries_max')) {
            $query->where('entered_entries', '<=', $request->entries_max);
        }

        // Amount filter
        if ($request->filled('amount_min')) {
            $query->where('total_amount', '>=', $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('total_amount', '<=', $request->amount_max);
        }

        $documents = $query->orderBy('created_at', 'desc')->get();

        return view('suretydocuments.index', compact('documents'));
    }

    public function create()
    {
        return view('suretydocuments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'total_expected_entries' => 'nullable|integer|min:1',
            'total_amount' => 'nullable|integer|min:0',
        ]);

        $file = $request->file('document');

        $path = $file->store('documents', 'public');

        SuretyDocument::create([
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'uploaded_by' => auth()->id(),
            'total_expected_entries' => $request->total_expected_entries,
            'total_amount' => $request->total_amount,
            'status' => 'uploaded'
        ]);

        return redirect()->route('suretydocuments.index')->with('success', 'Document uploaded successfully.');
    }

    public function lock($id)
    {
        $userId = auth()->id();

        $document = DB::transaction(function () use ($id, $userId) {

            $doc = SuretyDocument::where('id', $id)
                ->lockForUpdate()
                ->first();

            if (!$doc) {
                abort(404, 'Document not found');
            }

            // Already locked by someone else
            if ($doc->locked_by && $doc->locked_by !== $userId) {
                return null;
            }

            // Lock it
            $doc->update([
                'locked_by' => $userId,
                'locked_at' => Carbon::now(),
                'status'    => 'processing',
            ]);

            return $doc;
        });

        if (!$document) {
            return redirect()->back()->with('error', 'Document already locked by another user.');
        }

        return redirect()->route('surety.create', $document->id);
    }

    public function edit($id)
    {
        $doc = SuretyDocument::findOrFail($id);
        return view('suretydocuments.edit', compact('doc'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $doc = SuretyDocument::findOrFail($id);

        $request->validate([
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'total_expected_entries' => 'nullable|integer|min:1',
            'total_amount' => 'nullable|numeric|min:0',
        ]);

        // Replace file if uploaded
        if ($request->hasFile('file')) {

            // delete old file
            if ($doc->file_path && file_exists(storage_path('app/public/'.$doc->file_path))) {
                unlink(storage_path('app/public/'.$doc->file_path));
            }

            $path = $request->file('file')->store('documents', 'public');

            $doc->file_path = $path;
            $doc->original_name = $request->file('file')->getClientOriginalName();
            $doc->update([
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            ]);
        }

        $doc->update([
            'uploaded_by' => auth()->id(),
            'total_expected_entries' => $request->total_expected_entries,
            'total_amount' => $request->total_amount,
        ]);

        return redirect()->route('suretydocuments.index')
            ->with('success', 'Document updated successfully');
    }
}
