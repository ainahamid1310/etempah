<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->insert([
            'nama' => 'Pegawai Teknologi Maklumat',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('positions')->insert([
            'nama' => 'Penolong Pegawai Teknologi Maklumat',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('positions')->insert([
            'nama' => 'Penolong Pegawai Tadbir',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
    }
}
