<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $this->call(DepartmentsTableSeeder::class);
        // $this->call(PositionsTableSeeder::class);
        // $this->call(StatusRoomsTableSeeder::class);
        // $this->call(StatusVcsTableSeeder::class);
        $this->call(RoomsTableSeeder::class);
        $this->call(DepartmentRoomTableSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(ProfilesTableSeeder::class);
    }
}
