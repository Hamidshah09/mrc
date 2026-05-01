<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\SuretyDocument;

class SuretyDocumentController extends Controller
{
    public function index()
    {
        $documents = \App\Models\SuretyDocument::where(function ($q) {
                $q->whereNull('locked_by')
                ->orWhere('locked_by', auth()->id());
            })
            ->orderBy('created_at')
            ->get();

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
            'total_expected_entries' => 'nullable|integer|min:1'
        ]);

        $file = $request->file('document');

        $path = $file->store('documents', 'public');

        \App\Models\SuretyDocument::create([
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'uploaded_by' => auth()->id(),
            'total_expected_entries' => $request->total_expected_entries,
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
}
