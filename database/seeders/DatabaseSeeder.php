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
            UkBidangSeeder::class, // Seeder untuk tabel uk_bidang
            UkSeeder::class,       // Seeder untuk tabel uk
            Apl02Seeder::class,    // Seeder untuk tabel apl02
            SkemaSeeder::class,    // Seeder untuk tabel skema
        ]);
    }
}
