<?php
namespace Database\Seeders;

use App\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     *
     */
    public function run()
    {
        DB::table('departments')->insert([
            'nama' => 'Pejabat Timbalan Menteri',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => 'Pejabat Timbalan Menteri (Perdagangan)',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => 'Pejabat Timbalan Menteri (Industri)',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => 'Pejabat SU Politik Menteri',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => 'Pejabat Ketua Setiausaha (KSU)',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => 'Pejabat TKSU (Perdagangan)',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => 'Pejabat TKSU (Industri)',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => '	Pejabat TKSU (Pelaburan)',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => 'Pengurusan Sumber Manusia',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => 'Pejabat Penasihat',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => 'Perancangan Strategik',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => 'Sekretariat Perdagangan Strategik',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => '	Pejabat Perundangan',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => 'Akaun',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => 'Pejabat Audit Dalam',
            'keterangan' => '',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => 'Komunikasi Strategik',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => 'Unit KPI',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Unit Integriti',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Dasar dan Rundingan Pelbagaihala',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Hubungan Serantau dan Antarabangsa',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Hubungan Perdagangan dan Ekonomi Duahala',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Integrasi Ekonomi ASEAN',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Pembangunan Industri',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Keusahawanan Bumiputera dan IKS',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Sokongan Perdagangan dan Industri',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Dasar Pelaburan dan Fasilitasi Perdagangan',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Pembangunan Sektor Perkhidmatan',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Penyelarasan Isu Berkaitan Perdagangan dan Industri',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Rundingan Strategik',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => 'NKEA, Pemantauan dan Penilaian',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);

        DB::table('departments')->insert([
            'nama' => 'AKI dan Seranta',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Pengurusan Maklumat',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Pejabat Menteri II',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Kewangan',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Pentadbiran',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Pengurusan Sumber Manusia',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Pengurusan Ilmu dan Maklumat Digital',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Amalan Perdagangan',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Seksyen Dasar Bukan Sumber',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Seksyen Dasar Sumber',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Seksyen Daya Saing & Mampan Perniagaan',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Seksyen Hubungan Industri & Kerajaan',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Vendor',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Peningkatan Dan Pengembangan Perniagaan',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Saham Dan Ekuiti Bumiputera',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Pemerkasaan Dan Seranta',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Kerjasama Perdagangan Dan Industri',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Kawalan Eksport Dan Import',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Unit Urusetia Majlis & Protokol',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Pasukan Pengurusan Projek',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Pusat Inovasi Nilai',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Sekretariat APEC 2020',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'Bahagian Ekonomi Digital',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
        DB::table('departments')->insert([
            'nama' => 'NAICO',
            'keterangan' => 'Dasar Sektoral',
            'status' => 'aktif',
            'created_by' => '1',
        ]);
    }
}
