<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataPembimbingSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('data_pembimbings')->insert([
            'id_kota' => 1,
            'id_pembimbing' => 1,
        ]);
        DB::table('data_pembimbings')->insert([
            'id_kota' => 2,
            'id_dosen' => 3,
        ]);
        DB::table('data_pembimbings')->insert([
            'id_kota' => 3,
            'id_dosen' => 3,
        ]);
        DB::table('data_pembimbings')->insert([
            'id_kota' => 1,
            'id_dosen' => 1,
        ]);
        DB::table('data_pembimbings')->insert([
            'id_kota' => 2,
            'id_dosen' => 1,
        ]);
        DB::table('data_pembimbings')->insert([
            'id_kota' => 3,
            'id_dosen' => 1,
        ]);
        DB::table('data_pembimbings')->insert([
            'id_kota' => 1,
            'id_dosen' => 2,
        ]);
        DB::table('data_pembimbings')->insert([
            'id_kota' => 2,
            'id_dosen' => 2,
        ]);
        DB::table('data_pembimbings')->insert([
            'id_kota' => 2,
            'id_dosen' => 2,
        ]);

    }
}
