<?php

namespace App\Http\Controllers;

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
            'cnic' => 'required|max:13|min:13',
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
    public function index(Request $request){
        $query = BlackListDomicileApplications::orderBy('black_list_id', 'desc');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $searchType = $request->get('search_type');

            switch ($searchType) {
                case 'cnic':
                    $query->where('cnic', 'like', "%{$search}%");
                    break;
                case 'reason':
                    $query->where('reason', 'like', "%{$search}%");
                    break;
                case 'id':
                    $query->where('black_list_id', $search);
                    break;
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }
        // @dd($request->get('status'));
        // @dd($query->toSql());
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [$request->get('from_date'), $request->get('to_date')]);
        }
        
        $blacklists = $query->paginate(20);
        return view('blacklist-domiciles.index', compact('blacklists'));
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
