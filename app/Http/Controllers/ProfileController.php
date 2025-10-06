<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\UserRequest;
use App\Models\Position;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profiles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return view('profiles.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = decrypt($id);
        $layout = request()->layout;
        $departments = Department::orderBy('nama', 'ASC')->get();
        $positions = Position::orderBy('nama', 'ASC')->get();
        $user = User::where('id', $id)->first();
        $profile = Profile::find($user->id);
        if ($layout == 'applicant') {
            return view('profiles_applicant.view', compact('departments', 'positions', 'user', 'profile', 'layout'));
        } elseif ($layout == 'admin') {
            return view('profiles_admin.view', compact('departments', 'positions', 'user', 'profile', 'layout'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $layout = request()->layout;
        $departments = Department::orderBy('nama', 'ASC')->get();
        $positions = Position::orderBy('nama', 'ASC')->get();
        $user = User::where('id', $id)->first();

        if ($layout == 'applicant') {
            return view('profiles_applicant.edit', compact('departments', 'positions', 'user'));
        } elseif ($layout == 'admin') {
            return view('profiles_admin.edit', compact('departments', 'positions', 'user'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(request $request, $id)
    {
        $id = decrypt($id);
        $user = User::find($id);
        // return $user->no_kp;
        $layout = request()->layout;
        $request->validate(
            [
                'name' => 'required',
                'no_kp' => 'required|digits:12',
                'email' => 'required|email',
                'jawatan' => 'required',
                'bahagian' => 'required',
                'no_sambungan' => 'required|digits:4',
                'no_bimbit' => 'required|max:12',
            ],
            [
                'nama.required' => 'Medan Nama diperlukan',
                'no_kp.required' => 'Medan No. Kad Pengenalan diperlukan',
                'no_kp.digits' => 'Medan No. Kad Pengenalan mestilah 12 digit',
                'no_kp.unique' => 'No. Kad Pengenalan telah didaftarkan',
                'email.required' => 'Medan E-mel diperlukan',
                'email.email' => 'Alamat E-mel mestilah mengikut format e-mel contohnya marhad@miti.gov.my',
                'email.unique' => 'Alamat E-mel telah didaftarkan',
                'jawatan.required' => 'Medan Jawatan diperlukan',
                'bahagian.required' => 'Medan Bahagian diperlukan',
                'no_extension.required' => 'Medan No.Sambungan diperlukan',
                'no_extension.digits' => 'Medan No.Sambungan mestilah 4 digit',
                'no_bimbit.required' => 'Medan No.Bimbit diperlukan',
                'no_bimbit.max' => 'Medan No.Bimbit tidak lebih 12 digit',
            ]
        );


        $departments = Department::orderBy('nama', 'ASC')->get();
        $positions = Position::orderBy('nama', 'ASC')->get();



        $button = $request->button;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $profile = Profile::where('user_id', $id)->first();

        $profile->department_id = $request->bahagian;
        $profile->position_id = $request->jawatan;
        $profile->no_extension = $request->no_sambungan;
        $profile->no_bimbit = $request->no_bimbit;
        $profile->save();

        $msg = 'Maklumat Pengguna telah dikemaskini.';

        // if ($layout == 'applicant') {
        //     return view('profiles_applicant.view', compact('departments', 'positions', 'user'))->with('successMessage', $msg);
        // } elseif ($layout == 'admin') {
        // return view('profiles_admin.view', compact('departments', 'positions', 'user'))->with('successMessage', $msg);
        return back()->with('successMessage', $msg);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
