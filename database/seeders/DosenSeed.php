<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dosens')->insert([
            'id' => 1,
            'id_user' => 1,
            'inisial_dosen' => 'AA',
            'nama_dosen' => 'Admin',
            'nip' => '12345678',
        ]);
        // DB::table('dosens')->insert([
        //     'id' => 2,
        //     'id_user' => 2,
        //     'inisial_dosen' => 'BB',
        //     'nama_dosen' => 'Dosen B',
        //     'nip' => '12345',
        // ]);
        // DB::table('dosens')->insert([
        //     'id' => 3,
        //     'id_user' => 3,
        //     'inisial_dosen' => 'CC',
        //     'nama_dosen' => 'Dosen C',
        //     'nip' => '12345',
        // ]);
        // DB::table('dosens')->insert([
        //     'id' => 4,
        //     'id_user' => 4,
        //     'inisial_dosen' => 'DD',
        //     'nama_dosen' => 'Dosen D',
        //     'nip' => '12345',
        // ]);
        // DB::table('dosens')->insert([
        //     'id' => 5,
        //     'id_user' => 5,
        //     'inisial_dosen' => 'EE',
        //     'nama_dosen' => 'Dosen E',
        //     'nip' => '12345',
        // ]);
    }
}
