<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlackListDomicileApplications;
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

        BlackListDomicileApplications::create($request->all());
        return redirect()->back()->with('success', 'Applicant added to blacklist successfully.');

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


}
