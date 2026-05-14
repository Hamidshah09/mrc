<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\BlackListDomicileApplications;
use App\Models\BlackListHistory;
class BlackListController extends Controller
{
    public function create(){
        return view('blacklist-domiciles.create');
    }
    public function store(Request $request){
        $request->validate([
                    'cnic' => [
                'required',
                'min:13',
                'max:13',

                Rule::unique(BlackListDomicileApplications::class, 'cnic')
            ],
            'reason' => 'required|string|max:100',
            'status' => 'required|in:blocked,unblocked',
            'clearance_reason' => 'nullable|string|max:100',
        ]);

        $letter = BlackListDomicileApplications::create($request->all());
        BlackListHistory::create([
            'black_list_id' => $letter->black_list_id,
            'remarks' => $request->input('status'),
            'user_id' => auth()->id(),
        ]);
        return redirect()->route('domicile.blacklist.index')->with('success', 'Applicant added to blacklist successfully.');

    }
    public function index(Request $request)
    {
        $query = BlackListDomicileApplications::with('user')
            ->orderBy(
                'black_list_id',
                'desc'
            );

        /*
        |--------------------------------------------------------------------------
        | Universal Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );

            $query->where(function ($q) use ($search) {

                // ID
                $q->where(
                    'black_list_id',
                    'like',
                    "%{$search}%"
                )

                // CNIC
                ->orWhere(
                    'cnic',
                    'like',
                    "%{$search}%"
                )

                // Reason
                ->orWhere(
                    'reason',
                    'like',
                    "%{$search}%"
                );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Date Filters
        |--------------------------------------------------------------------------
        */

        if ($request->filled('from_date')) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->from_date
            );
        }

        if ($request->filled('to_date')) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->to_date
            );
        }

        $blacklists = $query
            ->paginate(20)
            ->appends(
                $request->query()
            );

        return view(
            'blacklist-domiciles.index',
            compact('blacklists')
        );
    }

    public function edit($id)
    {
        $blacklist = BlackListDomicileApplications::findOrFail($id);
        return view('blacklist-domiciles.edit', compact('blacklist'));
     }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cnic' => 'required|max:13|min:13',
            'reason' => 'required|string|max:100',
            'status' => 'required|in:blocked,unblocked',
            'clearance_reason' => 'nullable|string|max:100',
        ]);
        
        $letter = BlackListDomicileApplications::findOrFail($id);
        $history_remarks = '';
        if ($letter->status !== $request->input('status')) {
            
            if ($request->input('status') === 'unblocked') {
                $history_remarks = $request->input('clearance_reason');
            } else {
                $history_remarks = $request->input('reason');
            }
            
            $letter->save();
        }

        $letter->update($request->all());
        
        
        BlackListHistory::create([
            'black_list_id' => $letter->black_list_id,
            'remarks' => $request->input('status') . ' - ' . $history_remarks ?? '',
            'user_id' => auth()->id(),
        ]);

        if ($letter->status === 'unblocked') {
            return redirect()->route('domicile.blacklist.index')->with('success', 'Applicant unblocked successfully.');
        } else {
            return redirect()->route('domicile.blacklist.index')->with('success', 'Applicant updated successfully.');
        }

    }


}
