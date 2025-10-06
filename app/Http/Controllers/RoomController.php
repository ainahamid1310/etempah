<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\RoomRequest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::orderBy('nama', 'ASC')->get();
        return view('references.room.index', compact('rooms'));
    }

    public function list()
    {
        $rooms = Room::orderBy('nama', 'ASC')->get();
        return view('references.room.list', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::orderBy('nama', 'ASC')->get();
        $supervisors = User::role('approver-room')->where('is_admin', '1')->where('status', '1')->get();
        return view('references.room.create', compact('departments', 'supervisors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        $userId = Auth::id();

        $room = new Room();
        $room->nama = $request->nama_bilik;
        $room->nama_panjang = $request->nama_bilik_panjang;
        $room->nama_petugas = $request->nama_petugas;
        $room->no_tel_petugas = $request->no_tel_petugas;
        $room->department_id = $request->department;
        $room->aras = $request->aras;
        $room->kapasiti = $request->kapasiti;
        $room->is_equipment = $request->is_equipment;
        $room->is_projector = $request->is_projector;
        $room->keterangan = $request->keterangan;
        $room->status = $request->status;
        $room->is_auto = $request->is_auto;
        $room->is_upload = $request->is_upload;
        if ($request->is_auto == 'N') {
            $request->is_pantry = 'U'; //Undefined
        }
        $room->is_pantry = $request->is_pantry;
        $room->email_status = $request->email_status;
        $room->created_at = now();
        $room->created_by = $userId;
        $room->save();

        $room_id = $room->id;

        $supervisors = $request->supervisors;
        $departments = $request->departments;

        $room = Room::find($room_id);
        $room->departments()->attach($departments);
        $room->users()->attach($supervisors);

        $msg = 'Profil Bilik telah disimpan.';

        return redirect('/reference/room/show/' . encrypt($room_id))->with('successMessage', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show($room)
    {        
        $room = decrypt($room);
        $departments = Department::get();
        $room = Room::where('id', $room)->first();
        return view('references.room.show', compact('room', 'departments'));
    }

    public function show_applicant($room)
    {
        $room = decrypt($room);
        $departments = Department::get();
        $room = Room::where('id', $room)->first();
        return view('references.room.show_applicant', compact('room', 'departments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit($room)
    {
        // return $room;
        $room = decrypt($room);
        $room_users = Room::find($room)->users;
        $supervisorsRooms = $room_users->pluck('id')->toArray();

        $department_room = Room::find($room)->departments;
        $departmentsRooms = $department_room->pluck('id')->toArray();

        $departments = Department::orderBy('nama', 'ASC')->get();
        $room = Room::where('id', $room)->first();
        $supervisors = User::role('approver-room')->where('is_admin', '1')->where('status', '1')->get();
        return view('references.room.edit', compact('room', 'departments', 'supervisors', 'supervisorsRooms', 'departmentsRooms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequest $request, $room)
    {
        $room = decrypt($room);
        $room = Room::where('id', $room)->first();
        $userId = Auth::id();
        $room->nama = $request->nama_bilik;
        $room->nama_panjang = $request->nama_bilik_panjang;
        $room->nama_petugas = $request->nama_petugas;
        $room->no_tel_petugas = $request->no_tel_petugas;
        $room->department_id = $request->department;
        $room->aras = $request->aras;
        $room->kapasiti = $request->kapasiti;
        $room->is_equipment = $request->is_equipment;
        $room->is_projector = $request->is_projector;
        $room->is_upload = $request->is_upload;
        $room->keterangan = $request->keterangan;
        $room->status = $request->status;
        $room->is_auto = $request->is_auto;


        // kalau is_auto == 'N', email_status, room_supervisors & department_rooms remove
        // perlu message masa pilih tidak utk alert bgtau akan remove 3 fields
        if ($request->is_auto == 'Y') {
            $room->email_status = $request->email_status;
            $room->is_pantry = $request->is_pantry;
        } else {
            $room->email_status = 'U';
            $room->is_pantry = 'U';
        }

        $room->created_at = now();
        $room->created_by = $userId;
        $room->save();

        $room_supervisors = $request->supervisors;
        $department_rooms = $request->departments;

        if ($request->is_auto == 'Y') {
            $room->users()->sync($room_supervisors);
            $room->departments()->sync($department_rooms);
        } elseif ($request->is_auto == 'N') {
            $room->users()->detach($room_supervisors);
            $room->departments()->detach($department_rooms);
        }

        $msg = 'Profil Bilik telah disimpan.';

        return redirect('/reference/room/show/' . encrypt($room->id))->with('successMessage', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy($room)
    {
        $count = User::whereHas('rooms', function ($q) use ($room) {
            $q->where('room_user.room_id', $room);
        })->count();

        if ($count > 0) {
            $msg = 'Y';
            return redirect('/reference/room')->with('msg', $msg);
        } else {
            Room::find($room)->delete();
            $msg = 'Profil bilik telah dipadam.';
            return redirect('/reference/room')->with('successMessage', $msg);
        }
    }
}
