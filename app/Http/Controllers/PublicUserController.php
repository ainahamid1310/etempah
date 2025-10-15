<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Department;
use App\Http\Requests\UserRequest;
use App\Models\User as ModelsUser;
use App\Models\Position;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PublicUserController extends Controller
{
    public function create()
    {
        $departments = Department::orderBy('nama', 'ASC')->get();
        $positions = Position::orderBy('nama', 'ASC')->get();
        $contacts = Contact::orderBy('role', 'ASC')->get()->groupBy('role');
        return view('user_public.create', compact('departments', 'positions', 'contacts'));
    }

    public function store(UserRequest $request)
    {
        $user = new ModelsUser();
        $user->name = $request->nama;
        $user->no_kp = $request->no_kp;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status = '1';

        $user->is_admin = '0';
        $user->created_at = now();
        $user->save();

        $user->assignRole('user');

        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->department_id = $request->department;
        $profile->position_id = $request->position;
        $profile->no_extension = $request->no_extension;
        $profile->no_bimbit = $request->no_bimbit;
        $profile->created_at = now();
        $profile->save();
        // Auth::loginUsingId($user->id);

        $msg = 'Pendaftaran telah Berjaya. Sila log masuk menggunakan No. Kad Pengenalan dan Kata Laluan yang telah didaftarkan';
        //email dihantar kepada pemohon
        //
        // $msg = 'Maklumat Pengguna telah didaftarkan.';

        // return redirect('user_public/show/' . $user->id)->with('successMessage', $msg); Yang ni terus login
        // return redirect('/')->with('successMessage', $msg);
        return redirect()->back()->with('successMessage', $msg);
    }

    public function edit(User $user)
    {
        $departments = Department::orderBy('nama', 'ASC')->get();
        $positions = Position::orderBy('nama', 'ASC')->get();
        return view('user_public.edit', compact('user', 'positions', 'departments'));
    }

    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->updated_at = now();
        $user->save();

        $profile = Profile::where('user_id', $user->id)->first();
        $profile->department_id = $request->department;
        $profile->position_id = $request->position;
        $profile->no_extension = $request->no_extension;
        $profile->no_bimbit = $request->no_bimbit;
        $profile->created_at = now();
        $profile->save();

        $msg = 'Maklumat Pengguna telah dikemaskini.';

        return redirect('user_public/show/' . $user->id)->with('successMessage', $msg);
    }

    public function show(User $user)
    {
        $departments = Department::orderBy('nama', 'ASC')->get();
        $positions = Position::orderBy('nama', 'ASC')->get();

        return view('user_public.view', compact('user', 'positions', 'departments'));
    }
}
