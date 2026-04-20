<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dosens')->insert([
            'id' => 99,
            'id_user' => 99,
            'inisial_dosen' => 'AU',
            'nama_dosen' => 'Aurea',
            'nip' => '12345677',
        ]);
        DB::table('users')->insert([
            'id' => 1,
            'username' => 'AU',
            'role' => 'pembimbing',
            'password' => bcrypt('AU'),
        ]);
    }
}
