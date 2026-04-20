<?php

namespace Database\Seeders;

use App\Models\Bimbingan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            DataPembimbingSeed::class,
            DataPengujiSeed::class,
            DosenSeed::class,
            JadwalSeed::class,
            KoordinatorSeed::class,
            KotaSeed::class,
            UserSeed::class,
            BimbinganSeed::class,
            Dosen_RoleSeed::class,
            PemberkasanSeed::class,
            PembimbingSeed::class,
            PengujiSeed::class,
            RolesSeeder::class,
        ]);
    }
}
