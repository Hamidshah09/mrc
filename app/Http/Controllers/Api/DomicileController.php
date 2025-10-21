<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DomicileStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

use function Pest\Laravel\json;

class DomicileController extends Controller
{
    public function update(Request $request)
    {
        try{
            $validated=$request->validate([
                'parm'=>'required',
                'parm_type'=>'required|string|in:ID,Date',
                'status'=>'required|string|in:Approval Received,Objection,Sent for Approval,Exported,Pending',
                'remarks'=>'nullable|string|max:120'
            ]);
            
            if ($request->parm_type==='ID'){
                $doimicile = DomicileStatus::findOrFail($request->parm);
                $doimicile->status = $request->status;
                $doimicile->remarks = $request->remarks;
                $doimicile->save();
            }else{
                $date1 = Carbon::parse($request->input('parm'))->startOfDay();
                $date2 = Carbon::parse($request->input('parm'))->endOfDay();
                DomicileStatus::whereBetween('created_at', [$date1, $date2])->update([
                            'status'=>$request->status,
                ]);

            }

            return response()->json([
                'success'=>true,
                'message' => 'Status Updated successfully',
            ]);

        }catch (ValidationException $e) {
            return response()->json([
                'success'=>false,
                'errors'=>$e->errors(),
            ],422);
        }
        
    }
}
