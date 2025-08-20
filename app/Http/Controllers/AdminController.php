<?php

namespace App\Http\Controllers;

use App\Models\Passcode;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function create(){
        
        return view('domicile.passcode');
    }
    
    public function store(Request $request)
{
    $request->validate([
        'date' => 'required|date',
        'count' => 'required|integer|min:1|max:300'
    ]);

    $codes = [];
    while (count($codes) < $request->count) {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        if (!Passcode::where('code', $code)->where('valid_on', $request->date)->exists()) {
            $codes[] = ['code' => $code, 'valid_on' => $request->date];
        }
    }

    Passcode::insert($codes);

    return back()->with('status', 'Passcodes Generated');
    }
    public function gen_report(){
        return view('domicile.createreport');
    }
    public function report(Request $request)
    {
        $date = Carbon::parse($request->query('date'));
        $passcodes = Passcode::whereDate('valid_on', $date)->where('used', 'No')->get();

        return view('domicile.passcodereport', compact('passcodes', 'date'));
    }


}

