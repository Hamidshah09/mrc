<?php

namespace App\Http\Controllers;

use App\Models\designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   if (!empty($request->search)) { 
            $query = designation::orderByDesc('id');
            if($request->search_type=='designation'){
                $query->where('designation','like', "%".$request->search."%"); 
            }elseif($request->search_type=='id'){
                $query->where('id', $request->search);
            }
            $designations = $query->paginate(10);
                        
        }else{
            $designations = designation::orderByDesc('id')
                        ->paginate(10);
        }
        return view('designations.index', compact('designations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valided = $request->validate(['designation'=>'required|string|max:40']);
        designation::create($valided);
        return back()->with('success', 'New Designation Created');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(['designation'=>'required|string|max:40']);
        $designation = designation::findorfail($id);
        $designation->designation = $request->designation;
        $designation->save();
        return back()->with('success', 'Designation Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
