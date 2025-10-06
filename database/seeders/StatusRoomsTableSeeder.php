<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusRoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_rooms')->insert([
            'status_pentadbiran' => 'Baru',
            'status_pemohon' => 'Dalam Proses',
            'relate' => '0',
            'keterangan' => 'Permohonan Baru',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_rooms')->insert([
            'status_pentadbiran' => 'Lulus',
            'status_pemohon' => 'Lulus',
            'relate' => '1',
            'keterangan' => 'Keputusan permohonan baru dilulus',
            'status' => 'aktif',
            'created_by' => '1',
        ]);


        DB::table('status_rooms')->insert([
            'status_pentadbiran' => 'Permohonan Pembatalan',
            'status_pemohon' => 'Permohonan Pembatalan',
            'relate' => '2',
            'keterangan' => 'Permohonan pembatalan terhadap permohonan yang telah diluluskan',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_rooms')->insert([
            'status_pentadbiran' => 'Ditolak',
            'status_pemohon' => 'Ditolak',
            'relate' => '1',
            'keterangan' => 'Keputusan permohonan baru ditolak',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_rooms')->insert([
            'status_pentadbiran' => 'Lulus Pembatalan',
            'status_pemohon' => 'Batal',
            'relate' => '3',
            'keterangan' => 'Keputusan permohonan pembatalan diluluskan',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_rooms')->insert([
            'status_pentadbiran' => 'Ditolak Pembatalan',
            'status_pemohon' => 'Lulus',
            'relate' => '3',
            'keterangan' => 'Keputusan permohonan pembatalan ditolak',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_rooms')->insert([
            'status_pentadbiran' => 'Batal',
            'status_pemohon' => 'Batal Oleh Pemohon',
            'relate' => '1',
            'keterangan' => 'Pemohon membuat pembatalan permohonan Baru',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_rooms')->insert([
            'status_pentadbiran' => 'Permohonan Pindaan',
            'status_pemohon' => 'Permohonan Pindaan',
            'relate' => '2',
            'keterangan' => 'Pindaan bilik/tarikh/pax/makan terhadap permohonan yang telah diluluskan',
            'status' => 'tidak aktif',
            'created_by' => '1',
        ]);

        DB::table('status_rooms')->insert([
            'status_pentadbiran' => 'Pindaan diluluskan',
            'status_pemohon' => 'Pindaan diluluskan',
            'relate' => '8',
            'keterangan' => 'Keputusan pindaan bilik/tarikh/pax/makan diluluskan',
            'status' => 'tidak aktif',
            'created_by' => '1',
        ]);

        DB::table('status_rooms')->insert([
            'status_pentadbiran' => 'Pindaan Ditolak',
            'status_pemohon' => 'Pindaan Ditolak',
            'relate' => '8',
            'keterangan' => 'Keputusan pindaan bilik/tarikh/pax/makan ditolak',
            'status' => 'tidak aktif',
            'created_by' => '1',
        ]);

        DB::table('status_rooms')->insert([
            'status_pentadbiran' => 'Pindaan Oleh Pentadbir',
            'status_pemohon' => 'Pindaan Oleh Pentadbir',
            'relate' => '2',
            'keterangan' => 'Pindaan oleh pentadbir selepas kelulusan',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_rooms')->insert([
            'status_pentadbiran' => 'Batal oleh Pentadbir',
            'status_pemohon' => 'Batal oleh Pentadbir',
            'relate' => '2',
            'keterangan' => 'Batal oleh pentadbir selepas kelulusan',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_rooms')->insert([
            'status_pentadbiran' => 'Batal oleh Pentadbir',
            'status_pemohon' => 'Batal oleh Pentadbir',
            'relate' => '1',
            'keterangan' => 'Batal oleh pentadbir terhadap permohonan Baru',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_rooms')->insert([
            'status_pentadbiran' => 'Lulus Dengan Pindaan',
            'status_pemohon' => 'Lulus Dengan Pindaan',
            'relate' => '1',
            'keterangan' => 'Keputusan Lulus Dengan Pindaan terhadap permohonan baru',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
    }
}
