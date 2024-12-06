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
                'email' => 'robin@email.com',
                'password' => Hash::make('123123'),
                'no_hp' => '081234567890',
                'level' => 'user',
            ],
            [
                'email' => 'sakura@email.com',
                'password' => Hash::make('123456'),
                'no_hp' => '082345678901',
                'level' => 'user',
            ],
            [
                'email' => 'hiro@email.com',
                'password' => Hash::make('345345'),
                'no_hp' => '083456789012',
                'level' => 'user',
            ],
            [
                'email' => 'saijo@email.com',
                'password' => Hash::make('456456'),
                'no_hp' => '084567890123',
                'level' => 'user',
            ],
            [
                'email' => 'annisa@email.com',
                'password' => Hash::make('123123'),
                'no_hp' => '085678901234',
                'level' => 'user',
            ],
            [
                'email' => 'belda@email.com',
                'password' => Hash::make('123123'),
                'no_hp' => '085678901234',
                'level' => 'admin',
            ],
            [
                'email' => 'yeka@email.com',
                'password' => Hash::make('123123'),
                'no_hp' => '085678901234',
                'level' => 'asesi',
            ],
            [
                'email' => 'lintang@email.com',
                'password' => Hash::make('123123'),
                'no_hp' => '085678901234',
                'level' => 'asesor',
            ],
        ];

        foreach ($data as $item) {
            User::create($item);
        }
    }
}
