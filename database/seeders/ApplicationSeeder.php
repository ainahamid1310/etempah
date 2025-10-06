<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('applications')->insert([
            'user_id' => '1',
            'room_id' => '3',
            'nama_mesyuarat' => 'TEST 1',
            'tarikh_mula' => '2022-04-28 09:25:16',
            'tarikh_hingga' => '2022-04-28 09:25:16',
            'kategori_pengerusi' => '0',
            'nama_pengerusi' => 'Kamilah',
            'bilangan_tempahan' => '4',
            'perakuan' => '1',
            'created_at' => '2022-04-27 09:25:16',
            'created_by' => '1',
        ]);

        DB::table('applications')->insert([
            'user_id' => '1',
            'room_id' => '4',
            'nama_mesyuarat' => 'TEST 2',
            'tarikh_mula' => '2022-04-28 09:25:16',
            'tarikh_hingga' => '2022-04-28 09:25:16',
            'kategori_pengerusi' => '0',
            'nama_pengerusi' => 'Kamilah',
            'bilangan_tempahan' => '4',
            'perakuan' => '1',
            'created_at' => '2022-04-27 09:25:16',
            'created_by' => '1',

        ]);

        DB::table('applications')->insert([
            'user_id' => '1',
            'room_id' => '5',
            'nama_mesyuarat' => 'TEST 3',
            'tarikh_mula' => '2022-04-28 09:25:16',
            'tarikh_hingga' => '2022-04-28 09:25:16',
            'kategori_pengerusi' => '0',
            'nama_pengerusi' => 'Kamilah',
            'bilangan_tempahan' => '4',
            'perakuan' => '1',
            'created_at' => '2022-04-27 09:25:16',
            'created_by' => '1',

        ]);

        DB::table('applications')->insert([
            'user_id' => '1',
            'room_id' => '4',
            'nama_mesyuarat' => 'TEST 4',
            'tarikh_mula' => '2022-04-28 09:25:16',
            'tarikh_hingga' => '2022-04-28 09:25:16',
            'kategori_pengerusi' => '0',
            'nama_pengerusi' => 'Kamilah',
            'bilangan_tempahan' => '4',
            'perakuan' => '1',
            'created_at' => '2022-04-27 09:25:16',
            'created_by' => '1',

        ]);

        DB::table('applications')->insert([
            'user_id' => '1',
            'room_id' => '6',
            'nama_mesyuarat' => 'TEST 5',
            'tarikh_mula' => '2022-04-28 09:25:16',
            'tarikh_hingga' => '2022-04-28 09:25:16',
            'kategori_pengerusi' => '0',
            'nama_pengerusi' => 'Kamilah',
            'bilangan_tempahan' => '4',
            'perakuan' => '1',
            'created_at' => '2022-04-27 09:25:16',
            'created_by' => '1',

        ]);

        DB::table('applications')->insert([
            'user_id' => '1',
            'room_id' => '5',
            'nama_mesyuarat' => 'TEST 6',
            'tarikh_mula' => '2022-04-28 09:25:16',
            'tarikh_hingga' => '2022-04-28 09:25:16',
            'kategori_pengerusi' => '0',
            'nama_pengerusi' => 'Kamilah',
            'bilangan_tempahan' => '4',
            'perakuan' => '1',
            'created_at' => '2022-04-27 09:25:16',
            'created_by' => '1',

        ]);

        DB::table('applications')->insert([
            'user_id' => '1',
            'room_id' => '4',
            'nama_mesyuarat' => 'TEST 7',
            'tarikh_mula' => '2022-04-28 09:25:16',
            'tarikh_hingga' => '2022-04-28 09:25:16',
            'kategori_pengerusi' => '0',
            'nama_pengerusi' => 'Kamilah',
            'bilangan_tempahan' => '4',
            'perakuan' => '1',
            'created_at' => '2022-04-27 09:25:16',
            'created_by' => '1',

        ]);

        DB::table('applications')->insert([
            'user_id' => '1',
            'room_id' => '4',
            'nama_mesyuarat' => 'TEST 8',
            'tarikh_mula' => '2022-04-28 09:25:16',
            'tarikh_hingga' => '2022-04-28 09:25:16',
            'kategori_pengerusi' => '0',
            'nama_pengerusi' => 'Kamilah',
            'bilangan_tempahan' => '4',
            'perakuan' => '1',
            'created_at' => '2022-04-27 09:25:16',
            'created_by' => '1',

        ]);

        DB::table('applications')->insert([
            'user_id' => '1',
            'room_id' => '5',
            'nama_mesyuarat' => 'TEST 9',
            'tarikh_mula' => '2022-04-28 09:25:16',
            'tarikh_hingga' => '2022-04-28 09:25:16',
            'kategori_pengerusi' => '0',
            'nama_pengerusi' => 'Kamilah',
            'bilangan_tempahan' => '4',
            'perakuan' => '1',
            'created_at' => '2022-04-27 09:25:16',
            'created_by' => '1',

        ]);

        DB::table('applications')->insert([
            'user_id' => '1',
            'room_id' => '6',
            'nama_mesyuarat' => 'TEST 10',
            'tarikh_mula' => '2022-04-28 09:25:16',
            'tarikh_hingga' => '2022-04-28 09:25:16',
            'kategori_pengerusi' => '0',
            'nama_pengerusi' => 'Kamilah',
            'bilangan_tempahan' => '4',
            'perakuan' => '1',
            'created_at' => '2022-04-27 09:25:16',
            'created_by' => '1',

        ]);
    }
}
