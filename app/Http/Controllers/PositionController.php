<?php

namespace App\Http\Controllers;

use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = Position::orderBy('id', 'DESC')->get();
        return view('references.position.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('references.position.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $position = new Position();
        $position->nama = $request->nama;
        $position->keterangan = $request->keterangan;
        $position->status = $request->status;
        $position->created_by = Auth::user()->id;
        $position->created_at = now();
        $position->save();
        $msg = 'Maklumat Jawatan telah berjaya ditambah.';
        return redirect('reference/position')->with('successMessage', $msg);
    }

    /**
     * Display the specified resource.
     *;
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit($position)
    {
        $position = decrypt($position);
        $position = Position::where('id', $position)->first();
        return view('references.position.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $position)
    {
        $position = decrypt($position);
        $position = Position::where('id', $position)->first();
        $position->nama = $request->nama;
        $position->keterangan = $request->keterangan;
        $position->status = $request->status;
        $position->updated_by = Auth::user()->id;
        $position->updated_at = now();
        $position->save();
        $msg = 'Maklumat Jawatan telah berjaya dikemaskini.';
        return view('references.position.show')->with('successMessage', $msg)->with('position', $position);
    }

    // public function show($position)
    // {
    //     dd($department);
    //     $department = Department::where('id', $department)->first();

    //     return view('references.department.show', compact('department'));
    // }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy($position_id)
    {
        $position_id = decrypt($position_id);
        $position = Position::find($position_id);
        Position::find($position->id)->delete();
        $msg = 'Maklumat Jawatan telah dipadam.';
        return redirect('reference/position')->with('successMessage', $msg);
    }
}
