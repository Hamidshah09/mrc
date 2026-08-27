<?php

namespace App\Http\Controllers;

use App\Models\CropTemplate;
use Illuminate\Http\Request;

class CropTemplateController extends Controller
{
    public function index()
    {
        $fields = [
            'groom_name' => "Groom Name",
            'bride_name' => "Bride Name",
            'groom_father_name' => "Groom's Father Name",
            'bride_father_name' => "Bride's Father Name",
            'groom_passport' => "Groom Passport",
            'bride_passport' => "Bride Passport",
            'groom_cnic' => "Groom CNIC",
            'bride_cnic' => "Bride CNIC",
            'marriage_date' => "Marriage Date",
            'registration_date' => "Registration Date",
            'registrar_name' => "Registrar Name",
            'register_no' => "Register No",
        ];

        $templates = CropTemplate::all()->keyBy('field_name');

        return view('crop-templates.index', compact(
            'fields',
            'templates'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'field_name' => ['required', 'string'],
            'x' => ['required', 'integer', 'min:0'],
            'y' => ['required', 'integer', 'min:0'],
            'width' => ['required', 'integer', 'min:1'],
            'height' => ['required', 'integer', 'min:1'],
        ]);

        CropTemplate::updateOrCreate(
            [
                'field_name' => $validated['field_name'],
            ],
            [
                'x' => $validated['x'],
                'y' => $validated['y'],
                'width' => $validated['width'],
                'height' => $validated['height'],
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Crop template saved successfully.',
        ]);
    }
}