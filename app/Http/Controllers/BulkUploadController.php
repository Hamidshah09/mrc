<?php

namespace App\Http\Controllers;

use App\Models\Mrc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BulkUploadController extends Controller
{
    public function create()
    {
        return view('mrc.bulk-upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'images' => [
                'required',
                'array',
                'min:1',
            ],

            'images.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:20480',
            ],
        ]);

        $created = 0;

        foreach ($request->file('images') as $uploadedImage) {

            DB::transaction(function () use (
                $uploadedImage,
                &$created
            ) {

                /*
                 * Create an empty MRC record.
                 *
                 * Your database now allows the data
                 * entry fields to be NULL.
                 */
                $mrc = Mrc::create([
                    'user_id' => auth()->id(),
                    'created_by' => auth()->id(),
                    'status' => 'Pending',
                ]);

                $extension = strtolower(
                    $uploadedImage->getClientOriginalExtension()
                );

                $filename = 'original.' . $extension;

                $directory = "documents/{$mrc->id}";

                $imagePath = $uploadedImage->storeAs(
                    $directory,
                    $filename,
                    'public'
                );

                $mrc->update([
                    'image' => $imagePath,
                ]);

                $created++;
            });
        }

        return redirect()
            ->route('mrc.bulk-upload.create')
            ->with(
                'success',
                "{$created} document(s) uploaded successfully."
            );
    }
}