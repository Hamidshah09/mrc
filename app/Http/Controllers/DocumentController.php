<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::orderBy('created_at', 'desc')->get();
        return view('downloads.download', compact('documents'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:102400|mimes:zip,rar,7z,pdf,doc,docx,xls,xlsx,txt',
            'description' => 'nullable|string|max:100',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $originalName);
        $path = $file->storeAs('documents', $filename);

        $doc = Document::create([
            'description' => $request->input('description'),
            'original_name' => $originalName,
            'filename' => $filename,
            'path' => $path,
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);

        return back()->with('success', 'File uploaded successfully.');
    }

    public function download($id)
    {
        $document = Document::findOrFail($id);
        $fullPath = storage_path('app/' . $document->path);

        if (!file_exists($fullPath)) {
            abort(404);
        }

        return response()->download($fullPath, $document->original_name, [
            'Content-Type' => $document->mime ?? 'application/octet-stream'
        ]);
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        Storage::delete($document->path);
        $document->delete();
        return back()->with('success', 'File deleted.');
    }
}
