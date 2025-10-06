<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Session\Session as SessionSession;


class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Auth::user()->hasRole('approver-room')) {
            $i = ['Bilik'];
        } elseif (Auth::user()->hasRole('approver-vc')) {
            $i = ['VC'];
        } elseif (Auth::user()->hasRole('super-admin')) {
            $i = ['Bilik', 'VC'];
        }

        $announcements = Announcement::whereIn('kategori', $i)->orderBy('id', 'DESC')->get();
        return view('announcements.index', compact('announcements', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $announcement = new Announcement();
        $announcement->nama = $request->nama;
        $announcement->keterangan = $request->keterangan;
        $announcement->kategori = $request->kategori;
        $announcement->status = $request->status;
        $announcement->created_by = Auth::user()->id;
        $announcement->created_at = now();
        $announcement->save();
        $msg = 'Maklumat Informasi Umum telah berjaya ditambah.';


        return redirect()->back()->with('successMessage', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit($announcement_id)
    {
        $announcement_id = decrypt($announcement_id);
        $announcement = Announcement::find($announcement_id);
        return view('announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        $announcement = Announcement::where('id', $id)->first();
        $announcement->nama = $request->nama;
        $announcement->keterangan = $request->keterangan;
        $announcement->kategori = $request->kategori;
        $announcement->status = $request->status;
        $announcement->updated_by = Auth::user()->id;
        $announcement->updated_at = now();
        $announcement->save();
        $msg = 'Maklumat Informasi Umum telah berjaya dikemaskini.';


        return view('announcements.view')->with('successMessage', $msg)->with('announcement', $announcement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Announcement $announcement)
    {
        Announcement::where('id', $announcement->id)->delete();
        // return redirect('/announcement?i=' . $request->i);
        $msg = 'Maklumat Informasi Umum telah dipadam.';
        return redirect()->back()->with('successMessage', $msg);
    }
}
