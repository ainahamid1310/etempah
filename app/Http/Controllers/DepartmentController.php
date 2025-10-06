<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::orderBy('id', 'DESC')->get();
        return view('references.department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('references.department.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $department = new Department();
        $department->nama = $request->nama;
        $department->keterangan = $request->keterangan;
        $department->status = $request->status;
        $department->created_by = Auth::user()->id;
        $department->created_at = now();
        $department->save();
        $msg = 'Maklumat Bahagian telah berjaya ditambah.';
        return redirect('reference/department')->with('successMessage', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit($department)
    {
        $department = decrypt($department);
        $department = Department::where('id', $department)->first();

        return view('references.department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $department)
    {
        $department = decrypt($department);
        $department = Department::where('id', $department)->first();
        $department->nama = $request->nama;
        $department->keterangan = $request->keterangan;
        $department->status = $request->status;
        $department->updated_by = Auth::user()->id;
        $department->updated_at = now();
        $department->save();
        $msg = 'Maklumat Bahagian telah berjaya dikemaskini.';
        return view('references.department.view')->with('successMessage', $msg)->with('department', $department);
    }

    // public function show($department)
    // {

    //     $department = Department::where('id', $department)->first();

    //     return view('references.department.view', compact('department'));
    // }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy($department)
    {
        $department = decrypt($department);
        $department = Department::where('id', $department)->first();
        Department::find($department->id)->delete();
        $msg = 'Maklumat Bahagian telah dipadam.';
        return redirect('reference/department')->with('successMessage', $msg);
    }
}
