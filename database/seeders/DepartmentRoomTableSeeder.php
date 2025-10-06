<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentRoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('department_room')->insert([
            'department_id' => '1',
            'room_id' => '4',
            'created_at' => now()
        ]);

        DB::table('department_room')->insert([
            'department_id' => '2',
            'room_id' => '6',
            'created_at' => now()
        ]);

        DB::table('department_room')->insert([
            'department_id' => '3',
            'room_id' => '6',
            'created_at' => now()
        ]);

        DB::table('department_room')->insert([
            'department_id' => '4',
            'room_id' => '3',
            'created_at' => now()
        ]);

        DB::table('department_room')->insert([
            'department_id' => '5',
            'room_id' => '1',
            'created_at' => now()
        ]);

        DB::table('department_room')->insert([
            'department_id' => '6',
            'room_id' => '3',
            'created_at' => now()
        ]);

        DB::table('department_room')->insert([
            'department_id' => '7',
            'room_id' => '6',
            'created_at' => now()
        ]);

        DB::table('department_room')->insert([
            'department_id' => '7',
            'room_id' => '17',
            'created_at' => now()
        ]);

        DB::table('department_room')->insert([
            'department_id' => '7',
            'room_id' => '18',
            'created_at' => now()
        ]);

        DB::table('department_room')->insert([
            'department_id' => '8',
            'room_id' => '3',
            'created_at' => now()
        ]);

        DB::table('department_room')->insert([
            'department_id' => '9',
            'room_id' => '4',
            'created_at' => now()
        ]);

        DB::table('department_room')->insert([
            'department_id' => '10',
            'room_id' => '4',
            'created_at' => now()
        ]);

        DB::table('department_room')->insert([
            'department_id' => '11',
            'room_id' => '4',
            'created_at' => now()
        ]);
    }
}
