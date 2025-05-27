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
            ElemenUKSeeder::class,
            SkemaSeeder::class,
            UsersSeeder::class,
            AsesorSeeder::class,
            AsesisSeeder::class,
            PenanggungJawabSeeder::class,
            TUKSeeder::class,
            EventSeeder::class,
            MUKSeeder::class,
            AsesiPengajuanSeeder::class,
            UjianMUKSeeder::class,
            AsesiMUKSeeder::class,
            JadwalMUKSeeder::class,
            EventSkemaSeeder::class,
            BidangKompetensiSeeder::class,
        ]);
    }
}
