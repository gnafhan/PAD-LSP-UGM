<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

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
                'email' => 'yeka@mail.ugm.ac.id',
                'password' => ' ',
                'no_hp' => '081234567890',
                'level' => 'asesi',
            ],
            [
                'email' => 'sakura@mail.ugm.ac.id',
                'password' => '123456',
                'no_hp' => '082345678901',
                'level' => 'asesi',
            ],
            [
                'email' => 'hiro@mail.ugm.ac.id',
                'password' => '345345',
                'no_hp' => '083456789012',
                'level' => 'asesi',
            ],
            [
                'email' => 'dwianggaranajwansugama@mail.ugm.ac.id',
                'password' => '123123',
                'no_hp' => '085678901235',
                'level' => 'admin',
            ],
            [
                'email' => 'nadziraazhanifarahiya@mail.ugm.ac.id',
                'password' => '123123',
                'no_hp' => '085678901236',
                'level' => 'admin',
            ],
            [
                'email' => 'zhazhanurani@mail.ugm.ac.id',
                'password' => '123123',
                'no_hp' => '085678901246',
                'level' => 'admin',
            ],
            [
                'email' => 'dinar.nugroho.p@mail.ugm.ac.id',
                'password' => '123123',
                'no_hp' => '085678901226',
                'level' => 'admin',
            ],
            [
                'email' => 'budi@mail.ugm.ac.id',
                'password' => 'budi123',
                'no_hp' => '081234567899',
                'level' => 'asesi',
            ],

            // Account for automation testing purposes
            [
                'email' => 'adminDwi@ugm.ac.id',
                'password' => 'AdminDwi',
                'no_hp' => '085678901226',
                'level' => 'admin',
            ],
            [
                'email' => 'adminNafa@mail.ugm.ac.id',
                'password' => 'AdminNafa',
                'no_hp' => '085678901226',
                'level' => 'admin',
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
