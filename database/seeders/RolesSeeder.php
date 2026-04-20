<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id' => 1,
            'nama_role' => 'koordinator',
        ]);
        DB::table('roles')->insert([
            'id' => 2,
            'nama_role' => 'pembimbing',
        ]);
        DB::table('roles')->insert([
            'id' => 3,
            'nama_role' => 'penguji',
        ]);
    }
}
