<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusVcsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_vcs')->insert([
            'status_pentadbiran' => 'Draf',
            'status_pemohon' => '-',
            'relate' => '0',
            'keterangan' => 'Permohonan Baru tetapi menunggu proses kelulusan bilik',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_vcs')->insert([
            'status_pentadbiran' => 'Baru',
            'status_pemohon' => 'Dalam Proses',
            'relate' => '0',
            'keterangan' => 'Permohonan Baru',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_vcs')->insert([
            'status_pentadbiran' => 'Lulus',
            'status_pemohon' => 'Lulus',
            'relate' => '1',
            'keterangan' => 'Keputusan permohonan baru dilulus',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_vcs')->insert([
            'status_pentadbiran' => 'Ditolak',
            'status_pemohon' => 'Ditolak',
            'relate' => '1',
            'keterangan' => 'Keputusan permohonan baru ditolak',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_vcs')->insert([
            'status_pentadbiran' => 'Batal',
            'status_pemohon' => 'Batal Oleh Pemohon',
            'relate' => '1',
            'keterangan' => 'Pemohon membuat pembatalan permohonan Baru',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_vcs')->insert([
            'status_pentadbiran' => 'Permohonan Pindaan',
            'status_pemohon' => 'Permohonan Pindaan',
            'relate' => '2',
            'keterangan' => 'Pindaan terhadap permohonan yang telah diluluskan',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_vcs')->insert([
            'status_pentadbiran' => 'Pindaan diluluskan',
            'status_pemohon' => 'Pindaan diluluskan',
            'relate' => '5',
            'keterangan' => 'Keputusan pindaan diluluskan',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_vcs')->insert([
            'status_pentadbiran' => 'Pindaan Ditolak',
            'status_pemohon' => 'Pindaan Ditolak',
            'relate' => '5',
            'keterangan' => 'Keputusan pindaan ditolak',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_vcs')->insert([
            'status_pentadbiran' => 'Pindaan Oleh Pentadbir',
            'status_pemohon' => 'Pindaan Oleh Pentadbir',
            'relate' => '2',
            'keterangan' => 'Pindaan oleh pentadbir selepas kelulusan',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_vcs')->insert([
            'status_pentadbiran' => 'Batal oleh Pentadbir',
            'status_pemohon' => 'Batal oleh Pentadbir',
            'relate' => '2',
            'keterangan' => 'Batal oleh pentadbir selepas kelulusan',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_vcs')->insert([
            'status_pentadbiran' => 'Batal oleh Pentadbir',
            'status_pemohon' => 'Batal oleh Pentadbir',
            'relate' => '1',
            'keterangan' => 'Batal oleh pentadbir terhadap permohonan Baru',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('status_vcs')->insert([
            'status_pentadbiran' => 'Lulus Dengan Pindaan',
            'status_pemohon' => 'Lulus Dengan Pindaan',
            'relate' => '1',
            'keterangan' => 'Keputusan Lulus Dengan Pindaan terhadap permohonan baru',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
    }
}
