<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::role('approver-room')->where('is_admin', '1')->where('status', '1')->get();
        return view('admins.index', compact('users'));
    }

    public function create($id)
    {
        // $roles = \Spatie\Permission\Models\Role::all();
        // $departments = Department::get();
        // $positions = Position::get();
        // $user = User::find($id);
        // $rooms = Room::get();
        // return view('admins.view', compact('user', 'positions', 'departments', 'roles', 'rooms'));
    }

    public function store(Request $request, $id)
    {

        $rooms = $request->rooms;

        $supervisor = User::find($id);

        $supervisor->rooms()->attach($rooms);

        $msg = 'Maklumat bilik pentadbir telah didaftarkan.';

        return redirect('admin/show/' . encrypt($id))->with('successMessage', $msg);
    }

    public function show($id)
    {
        $id = decrypt($id);
        $roles = \Spatie\Permission\Models\Role::all();
        $departments = Department::get();
        $positions = Position::get();
        $user = User::find($id);
        $rooms = Room::get();

        $room_users = User::find($user->id)->rooms;
        $supervisorsRooms = $room_users->pluck('id')->toArray();

        return view('admins.view', compact('user', 'positions', 'departments', 'roles', 'rooms', 'supervisorsRooms'));
    }

    public function edit($user)
    {
        $user = decrypt($user);
        $roles = \Spatie\Permission\Models\Role::all();
        $departments = Department::get();
        $positions = Position::get();
        $user = User::find($user);
        // return $user;
        $rooms = Room::where('is_auto', 'Y')->get();
        // return $rooms;

        $room_users = User::find($user->id)->rooms;

        $supervisorsRooms = $room_users->pluck('id')->toArray();

        return view('admins.edit', compact('user', 'positions', 'departments', 'roles', 'rooms', 'supervisorsRooms'));
    }

    public function update(Request $request, $user)
    {
        $user = decrypt($user);
        $room_supervisors = $request->rooms;
        $user = User::find($user);
        $user->rooms()->sync($room_supervisors);

        $msg = 'Maklumat Bilik telah disimpan.';

        return redirect('admin/show/' . encrypt($user->id))->with('successMessage', $msg);
    }

    public function updatePassword(Request $request, User $user)
    {
        return ('reset password');
        $validatedData = $request->validate([
            'password' => 'required|string|min:8',
        ]);

        //Change Password
        $tempPwd = $request->get('password');
        $user->password = bcrypt($request->get('password'));
        $user->save();

        return back()->with('successMessage', 'Kata Laluan pengguna telah dikemaskini. Notifikasi e-mel telah dihantar kepada pengguna.');
    }

    public function destroy($user)
    {
        User::find($user)->delete();

        $msg = 'Maklumat Pengguna telah dipadam.';

        return back()->withInput()->with('successMessage', $msg);
    }
}
