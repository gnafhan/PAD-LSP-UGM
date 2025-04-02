<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid constraints issues during seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Truncate the table first for clean seeding
        DB::table('users')->truncate();
        
        // Predefined users with specific details
        $predefinedUsers = [
            [
                'email' => 'yeka@email.com',
                'password' => '123123',
                'no_hp' => '081234567890',
                'level' => 'asesi',
            ],
            [
                'email' => 'sakura@email.com',
                'password' => '123456',
                'no_hp' => '082345678901',
                'level' => 'asesi',
            ],
            [
                'email' => 'hiro@email.com',
                'password' => '345345',
                'no_hp' => '083456789012',
                'level' => 'asesi',
            ],
            [
                'email' => 'annisa@email.com',
                'password' => '123123',
                'no_hp' => '085678901234',
                'level' => 'user',
            ],
            [
                'email' => 'belda@email.com',
                'password' => '123123',
                'no_hp' => '085678901234',
                'level' => 'admin',
            ],
            [
                'email' => 'lintang@email.com',
                'password' => '123123',
                'no_hp' => '085678901234',
                'level' => 'asesor',
            ],
        ];

        // Seed predefined users using the model to leverage boot method
        foreach ($predefinedUsers as $userData) {
            User::create([
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'no_hp' => $userData['no_hp'],
                'level' => $userData['level'],
            ]);
        }

        // Generate additional users using the model
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'email' => "user{$i}@email.com",
                'password' => Hash::make('password123'),
                'no_hp' => '0812345678' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'level' => 'asesi',
            ]);
        }
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}