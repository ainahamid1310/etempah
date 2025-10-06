<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'approver_room-list',
            'approver_room-create',
            'approver_room-edit',
            'approver_room-delete',
            'vc-list',
            'vc-create',
            'vc-edit',
            'vc-delete',
            'application-list',
            'application-create',
            'application-edit',
            'application-delete',
            'report-pmsb',
            'report-bizpoint',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'super-admin']);
        $role1->givePermissionTo(Permission::all());

        $role2 = Role::create(['name' => 'admin-room']);
        $role2->givePermissionTo(['user-list', 'user-create', 'user-edit', 'user-delete']);
        // $role2->givePermissionTo(['data-list', 'data-create', 'data-edit']);

        $role3 = Role::create(['name' => 'approver-room']);
        $role3->givePermissionTo(['approver_room-list', 'approver_room-create', 'approver_room-edit']);

        $role4 = Role::create(['name' => 'approver-vc']);
        $role4->givePermissionTo(['vc-list', 'vc-create', 'vc-edit']);

        $role5 = Role::create(['name' => 'user']);
        $role5->givePermissionTo(['application-list', 'application-create', 'application-edit']);

        $role6 = Role::create(['name' => 'pmsb']);
        $role6->givePermissionTo(['report-pmsb']);

        $role7 = Role::create(['name' => 'biz-point']);
        $role7->givePermissionTo(['report-bizpoint']);

        // create users
        $user = User::create([
            'name' => 'APEG Team',
            'email' => 'apeg.team@gmail.com',
            'password' => Hash::make('password'),
            'no_kp' => '801013142000',
            'foto' => 'imgs/user/default.png',
            'is_admin' => '1',
        ]);
        $user->assignRole($role1);

        $user = User::create([
            'name' => 'APEG Team 2',
            'email' => 'apeg.team2@gmail.com',
            'password' => Hash::make('password'),
            'no_kp' => '801013142001',
            'foto' => 'imgs/user/default.png',
            'is_admin' => '1',
        ]);
        $user->assignRole($role2);

        $user = User::create([
            'name' => 'Saripah Subairi',
            'email' => 'saripah@miti.gov.my',
            'password' => Hash::make('password'),
            'no_kp' => '801013142002',
            'foto' => 'imgs/user/default.png',
            'is_admin' => '1',

        ]);
        $user->assignRole($role3);

        $user = User::create([
            'name' => 'Zulkifli Din',
            'email' => 'zulkifli@miti.gov.my',
            'password' => Hash::make('password'),
            'no_kp' => '801013142003',
            'foto' => 'imgs/user/default.png',
            'is_admin' => '1',

        ]);
        $user->assignRole($role4);

        $user = User::create([
            'name' => 'Nur Asma Wanis Jusoh',
            'email' => 'asma.jusoh@miti.gov.my',
            'password' => Hash::make('password'),
            'no_kp' => '801013142004',
            'foto' => 'imgs/user/default.png',
            'is_admin' => '0',

        ]);
        $user->assignRole($role5);
    }
}
