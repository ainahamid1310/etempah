<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('room_user')->truncate();

        $csvFile = fopen(base_path("seeder_room_user.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                DB::table('room_user')->insert([
                    "room_id" => $data['0'],
                    "user_id" => $data['1']
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
