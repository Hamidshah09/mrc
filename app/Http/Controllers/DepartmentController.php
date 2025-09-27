<?php

namespace App\Http\Controllers;

use App\Models\department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!empty($request->search)) { 
            $query = department::orderByDesc('id');
            if($request->search_type=='department'){
                $query->where('department','like', "%".$request->search."%"); 
            }elseif($request->search_type=='id'){
                $query->where('id', $request->search);
            }
            $departments = $query->paginate(10);
                        
        }else{
            $departments = department::orderByDesc('id')
                        ->paginate(10);
        }
        return view('departments.index', compact('departments'));
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
        $valided = $request->validate(['department'=>'required|string|max:40']);
        department::create($valided);
        return back()->with('success', 'New Department Created');
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
        $request->validate(['department'=>'required|string|max:40']);
        $department = department::findorfail($id);
        $department->department = $request->department;
        $department->save();
        return back()->with('success', 'Department Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
