<?php
namespace Database\Seeders;

use App\DepartmentRoom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DepartmentRoom::truncate();

        $csvFile = fopen(base_path("seeder_department_room.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                DB::table('department_room')->insert([
                    "department_id" => $data['0'],
                    "room_id" => $data['1']
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
