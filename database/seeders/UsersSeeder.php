<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'email' => 'user1@example.com',
                'password' => Hash::make('123123'),
                'no_hp' => '081234567890',
                'level' => 'user',
            ],
            [
                'email' => 'user2@example.com',
                'password' => Hash::make('123456'),
                'no_hp' => '082345678901',
                'level' => 'user',
            ],
            [
                'email' => 'user3@example.com',
                'password' => Hash::make('345345'),
                'no_hp' => '083456789012',
                'level' => 'user',
            ],
            [
                'email' => 'user4@example.com',
                'password' => Hash::make('456456'),
                'no_hp' => '084567890123',
                'level' => 'user',
            ],
            [
                'email' => 'user5@example.com',
                'password' => Hash::make('567567'),
                'no_hp' => '085678901234',
                'level' => 'user',
            ],
        ];

        foreach ($data as $item) {
            User::create($item);
        }
    }
}
