<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataPengujiSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('data_pengujis')->insert([
            'id_kota' => 1,
            'id_penguji' => 1,
        ]);
        DB::table('data_pengujis')->insert([
            'id_kota' => 5,
            'id_dosen' => 1,
        ]);
        DB::table('data_pengujis')->insert([
            'id_kota' => 4,
            'id_dosen' => 2,
        ]);
        DB::table('data_pengujis')->insert([
            'id_kota' => '-',
            'id_dosen' => 2,
        ]);
        DB::table('data_pengujis')->insert([
            'id_kota' => '-',
            'id_dosen' => 2,
        ]);

    }
}
