<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UKBidangSeeder::class,
            UKSeeder::class,
            SkemaSeeder::class,
            EventSeeder::class,
            UsersSeeder::class,
            AsesorSeeder::class,
            AsesisSeeder::class,
            PenanggungJawabSeeder::class,
            TUKSeeder::class,
            MUKSeeder::class,
            AsesiPengajuanSeeder::class,
            UjianMUKSeeder::class,
            AsesiUKSeeder::class,
            AsesiMUKSeeder::class,
            JadwalMUKSeeder::class,
            AsesiApl02Seeder::class,
            EventSkemaSeeder::class,
        ]);
    }
}
