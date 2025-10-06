<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Profiles')->insert([
            'user_id' => '1',
            'department_id' => '1',
            'position_id' => '1',
            'no_extension' => '1232',
            'no_bimbit' => '012-6654342',
        ]);

        DB::table('Profiles')->insert([
            'user_id' => '2',
            'department_id' => '1',
            'position_id' => '2',
            'no_extension' => '1233',
            'no_bimbit' => '012-6654343',
        ]);

        DB::table('Profiles')->insert([
            'user_id' => '3',
            'department_id' => '1',
            'position_id' => '3',
            'no_extension' => '1238',
            'no_bimbit' => '012-6654388',
        ]);

  
    }
}
