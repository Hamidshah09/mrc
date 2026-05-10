<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DomicileStatus;
use App\Models\DomicileApplicants;
use App\Models\BlackListDomicileApplications;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use function Pest\Laravel\json;

class DomicileController extends Controller
{
    public function update_bluck_status(Request $request)
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

    public function getByCnic($cnic)
    {
        try {
            $record = DomicileApplicants::with('children')->where('cnic', $cnic)->firstOrFail();
            return response()->json([
                'success' => true,
                'data' => $record,
            ]);
        } catch (\Exception $e) {
            Log::error('DomicileApplicants show api error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Record not found',
            ], 404);
        }
    
    }

    /**
     * Return a single DomicileApplicants record (all columns) by id.
     */
    public function getById($id)
    {
        try {
            $record = DomicileApplicants::with('children')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $record,
            ]);
        } catch (\Exception $e) {

            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }


    /**
     * Upload and save applicant picture. Stores file in `public` disk and saves URL to `picture_path`.
     */
    public function uploadPicture(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'picture' => 'required|image|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $applicant = DomicileApplicants::findOrFail($id);
            $path = $request->file('picture')->store('domicile_pictures', 'public');
            $url = Storage::url($path);
            $applicant->picture_path = $url;
            $applicant->save();

            return response()->json([
                'success' => true,
                'picture_path' => $url,
            ], 200);
        } catch (\Exception $e) {
            Log::error('uploadPicture error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unable to upload picture',
            ], 500);
        }
    }

    public function update_status(Request $request)
    {
        try{
            $validated=$request->validate([
                'parm'=>'required',
                'status'=>'required|string|in:Approval Received,Objection,Sent for Approval,Exported,Pending',
            ]);
            
            $domicile = DomicileApplicants::findOrFail($request->parm);
            $domicile->status = $request->status;
            $domicile->save();

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

    public function getApprovers()
    {
        try {
            $approvers = DomicileApplicants::select('approver')->distinct()->pluck('approver');
            return response()->json([
                'success' => true,
                'approvers' => $approvers,
            ]);
        } catch (\Exception $e) {
            Log::error('getApprovers error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve approvers',
            ], 500);
        }
    }

    public function getblacklistedapplicant($cnic)
    {
        try {
            $isBlacklisted = BlackListDomicileApplications::where('cnic', $cnic)
            ->where('status', 'blocked')
            ->exists();

            return response()->json([
                'success' => true,
                'is_blacklisted' => $isBlacklisted,
            ]);
        } catch (\Exception $e) {
            Log::error('getblacklistedapplicant error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
