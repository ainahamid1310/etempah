<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\UserRequest;
use App\Models\Position;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
// use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class UserController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        // $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $users = User::get();
        $departments = Department::orderBy('nama', 'ASC')->get();
        $positions = Position::orderBy('nama', 'ASC')->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $roles = \Spatie\Permission\Models\Role::all();
        $departments = Department::where('status', 'aktif')->orderBy('nama', 'ASC')->get();
        $positions = Position::where('status', 'aktif')->orderBy('nama', 'ASC')->get();
        return view('user.create', compact('roles', 'departments', 'positions'));
    }

    public function store(UserRequest $request)
    {
        $user = new User();
        $user->name = $request->nama;
        $user->no_kp = $request->no_kp;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status = $request->status;

        if ($request->role == 'user') {
            $is_admin = '0';
        } else {
            $is_admin = '1';
        }

        $user->is_admin = $is_admin;
        $user->created_at = now();
        $user->save();

        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->department_id = $request->department;
        $profile->position_id = $request->position;
        $profile->no_extension = $request->no_extension;
        $profile->no_bimbit = $request->no_bimbit;
        $profile->created_at = now();
        $profile->save();

        $user->assignRole($request->input('role'));

        $msg = 'Maklumat Pengguna telah didaftarkan.';

        return redirect('user/show/' . encrypt($user->id))->with('successMessage', $msg);
        // return redirect('user/show/' . encrypt($user->id))->with('successMessage', $msg);
    }

    public function show($user)
    {
        $user = decrypt($user);
        $user = User::find($user);
        $roles = \Spatie\Permission\Models\Role::all();
        $departments = Department::orderBy('nama', 'ASC')->get();
        $positions = Position::orderBy('nama', 'ASC')->get();
        $profile = Profile::where('user_id', $user->id)->first();
        return view('user.view', compact('user', 'profile', 'positions', 'departments'));
    }

    public function edit($user)
    {
        $user = decrypt($user);
        $user = User::find($user);
        $roles = \Spatie\Permission\Models\Role::all();
        $departments = Department::where('status', 'aktif')->orderBy('nama', 'ASC')->get();
        $positions = Position::where('status', 'aktif')->orderBy('nama', 'ASC')->get();
        $profile = Profile::where('user_id', $user->id)->first();
        return view('user.edit', compact('user', 'profile', 'positions', 'departments', 'roles'));
    }

    public function update(Request $request, $user)
    {
        $user = decrypt($user);
        $user = User::find($user);
        $request->validate(
            [
                'nama' => 'required',
                'email' => 'email',
                'position' => 'required',
                'department' => 'required',
                'no_extension' => 'required|digits:4',
                'no_bimbit' => 'required|max:12',
                // 'reset_password' => 'nullable|min:8',
                'reset_password' => 'nullable|min:12|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',
                'status' => 'required',
            ],
            [
                'nama.required' => 'Medan Nama diperlukan',
                'email.email' => 'Sila isi Alamat E-mel yang betul',
                'email.unique' => 'Alamat E-mel telah didaftarkan',
                'position.required' => 'Medan Jawatan diperlukan',
                'department.required' => 'Medan Bahagian diperlukan',
                'no_extension.required' => 'Medan No.Sambungan diperlukan',
                'no_extension.digits' => 'Medan No.Sambungan mestilah 4 digit',
                'no_bimbit.required' => 'Medan No.Bimbit diperlukan',
                'no_bimbit.max' => 'Medan No.Bimbit tidak lebih 12 digit',
                'reset_password.min' => 'Medan kata laluan mestilah sekurang-kurangnya dua belas (12) aksara dengan gabungan nombor, simbol, huruf besar dan huruf kecil',
                'reset_password.regex' => 'Medan kata laluan mestilah sekurang-kurangnya dua belas (12) aksara dengan gabungan nombor, simbol, huruf besar dan huruf kecil',
                'status.required' => 'Medan Status diperlukan',
            ]
        );

        $user->name = $request->nama;
        $user->email = $request->email;

        if (!empty($request->reset_password)) {
            $new_password = Hash::make($request->reset_password);
            $user->password = $new_password;
        }

        if ($request->role == '5') {
            $is_admin = '0';
        } else {
            $is_admin = '1';
        }
        $user->is_admin = $is_admin;

        $user->status = $request->status;
        $user->created_at = now();
        $user->save();

        $profile = Profile::where('user_id', $user->id)->first();

        if (empty($profile)) {

            $profile = new Profile();
            $profile->user_id = $user->id;
        }
        $profile->department_id = $request->department;
        $profile->position_id = $request->position;
        $profile->no_extension = $request->no_extension;
        $profile->no_bimbit = $request->no_bimbit;
        $profile->created_at = now();
        $profile->save();

        DB::table('model_has_roles')->where('model_id', $user->id)->delete();

        // $user->assignRole($request->input('role'));
        $roleName = Role::find(3)->name;
        $user->assignRole($roleName);

        // $positions = Position::get();
        // $departments = Department::get();
        $msg = 'Maklumat Pengguna telah disimpan.';

        return redirect('user/show/' . encrypt($user->id))->with('successMessage', $msg);
    }

    public function updatePassword(Request $request, User $user)
    {
        $layout = request()->layout;

        $request->validate(
            [
                'password_old' => 'required',
                'password' => 'required|min:12|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',
                'password_confirm' => 'required|same:password|min:12',
            ],

            [
                'password_old.required' => 'Medan Kata Laluan Lama diperlukan',
                'password.required' => 'Medan Kata laluan diperlukan',
                'password.min' => 'Medan kata laluan mestilah sekurang-kurangnya dua belas (12) aksara dengan gabungan nombor, simbol, huruf besar dan huruf kecil',
                'password.regex' => 'Medan kata laluan mestilah sekurang-kurangnya dua belas (12) aksara dengan gabungan nombor, simbol, huruf besar dan huruf kecil',
                'password_confirm.required' => 'Medan Ulang Kata laluan diperlukan',
                'password_confirm.same' => 'Medan Ulang Kata laluan mestilah sama dengan medan kata laluan',
                'password_confirm.min' => 'Medan Ulang Kata laluan mestilah sama dengan medan kata laluan',
            ]

        );


        if (!Hash::check($request->password_old, $user->password)) {
            return back()->with('errorMessage', 'Kata laluan Lama tidak sepadan');
        }

        //Change Password
        // $tempPwd = $request->get('password_old');
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('profile/edit/' . encrypt($user->id) . '?layout=' . $layout)->with('successMessage', 'Kata Laluan pengguna telah dikemaskini.');
    }

    public function destroy($user)
    {
        User::find($user)->delete();

        $msg = 'Maklumat Pengguna telah dipadam.';

        return redirect('user/')->with('successMessage', $msg);
    }
}
