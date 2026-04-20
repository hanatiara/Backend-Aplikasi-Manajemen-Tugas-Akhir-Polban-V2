<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KotaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kotas')->insert([
            'id' => 1,
            'nama_kota' => '101',
            'prodi' => 'D3',
            'tahun_ajaran' => '2018',
            'nama_mahasiswa1' => '-',
            'nama_mahasiswa2' => '-',
            'nama_mahasiswa3' => '-',
            'nim1' => '-',
            'nim2' => '-',
            'nim3' => '-',
            'judul_ta' => '-',
            'id_user' => '7',
        ]);
        DB::table('kotas')->insert([
            'id' => 2,
            'nama_kota' => '102',
            'prodi' => 'D3',
            'tahun_ajaran' => '2018',
            'nama_mahasiswa1' => '-',
            'nama_mahasiswa2' => '-',
            'nama_mahasiswa3' => '-',
            'nim1' => '-',
            'nim2' => '-',
            'nim3' => '-',
            'judul_ta' => '-',
            'id_user' => '7',
        ]);
        DB::table('kotas')->insert([
            'id' => 2,
            'nama_kota' => '103',
            'prodi' => 'D3',
            'tahun_ajaran' => '2018',
            'nama_mahasiswa1' => '-',
            'nama_mahasiswa2' => '-',
            'nama_mahasiswa3' => '-',
            'nim1' => '-',
            'nim2' => '-',
            'nim3' => '-',
            'judul_ta' => '-',
            'id_user' => '7',
        ]);

    }
}
