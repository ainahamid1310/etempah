<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        // $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->get();

        return view('role.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $permissions = Permission::get();

        return view('role.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|unique:roles,name',
                'permission' => 'required',
            ],
            [
                'name.required' => 'Peranan diperlukan.',
                'name.unique'  => 'Peranan telah wujud.',
                'permission.required' => 'Tetapan Akses diperlukan.'
            ]
        );

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect('/role')->with('success', 'Maklumat peranan berjaya disimpan.');
    }

    public function show($id)
    {
        $role = Role::find($id);

        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('role.show', compact('role', 'rolePermissions'));
    }

    public function edit($id)
    {
        $role = Role::find($id);

        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('role.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|unique:roles,name,' . $id,
                'permission' => 'required',
            ],
            [
                'name.required' => 'Peranan diperlukan.',
                'name.unique'  => 'Peranan telah wujud.',
                'permission.required' => 'Tetapan Akses diperlukan.'
            ]
        );

        $role = Role::find($id);

        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('/role')
            ->with('success', 'Maklumat peranan berjaya dikemas kini.');
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();

        return redirect()->route('role.index')
            ->with('success', 'Maklumat peranan berjaya dipadam.');
    }
}
