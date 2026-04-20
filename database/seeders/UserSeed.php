<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'username' => 'AA',
            'role' => 'pembimbing',
            'password' => bcrypt('AA'),
        ]);
        DB::table('users')->insert([
            'id' => 7,
            'username' => '107',
            'role' => 'kota',
            'password' => bcrypt('107'),
        ]);
        // DB::table('users')->insert([
        //     'id' => 3,
        //     'username' => 'CC',
        //     'role' => 'pembimbing',
        //     'password' => 'CC',
        // ]);
        // DB::table('users')->insert([
        //     'id' => 4,
        //     'username' => 'DD',
        //     'role' => 'pembimbing',
        //     'password' => 'DD',
        // ]);
        // DB::table('users')->insert([
        //     'id' => 5,
        //     'username' => 'EE',
        //     'role' => 'pembimbing',
        //     'password' => 'EE',
        // ]);
        // DB::table('users')->insert([
        //     'id' => 23,
        //     'username' => 'koordinator',
        //     'role' => 'koordinator',
        //     'password' => bcrypt('koordinator'),
        // ]);
        // DB::table('users')->insert([
        //     'id' => 24,
        //     'username' => 'kota',
        //     'role' => 'kota',
        //     'password' => bcrypt('kota'),
        // ]);
        // DB::table('users')->insert([
        //     'id' => 25,
        //     'username' => 'dosen',
        //     'role' => 'dosen',
        //     'password' => bcrypt('dosen'),
        // ]);

    }
}
