<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jadwals')->insert([
            'id' => 1,
            'nama_file' => 'lorem.pdf',
            'keterangan' => 'keterangan',
            'url' => '/lorem.pdf',
        ]);
    }
}
