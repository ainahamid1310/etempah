<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Hajariah',
            'email' => 'hajariah@miti.gov.my',
            'password' => bcrypt('password'),
            'no_kp' => '801013146112',
            'foto' => 'imgs/user/default.png',
            'is_admin' => '1',
            'status' => '1',
        ]);

        DB::table('users')->insert([
            'name' => 'Abdul Hadi',
            'email' => 'hadi@miti.gov.my',
            'password' => bcrypt('password'),
            'no_kp' => '801013146111',
            'foto' => 'imgs/user/default.png',
            'is_admin' => '1',
            'status' => '1',
        ]);

        DB::table('users')->insert([
            'name' => 'Siti Noor Aina Abdul Hamid',
            'email' => 'nooraina12@miti.gov.my',
            'password' => bcrypt('password'),
            'no_kp' => '801013146114',
            'foto' => 'imgs/user/default.png',
            'is_admin' => '0',
            'status' => '1',
        ]);

        // $user = new User();
        // $user->name = 'Siti Noor Aina';
        // $user->email = 'nooraina@miti.gov.my';
        // $user->password = bcrypt('password');
        // $user->no_kp = '801013146114';
        // $user->foto = 'imgs/user/default.png';
        // $user->status = '1';
        // $user->is_admin = '1';
        // $user->save();
        // $user->assignRole('superadmin');
    }
}
