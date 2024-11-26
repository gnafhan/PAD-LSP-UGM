<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apl02;

class Apl02Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_uk' => 'UK1',
            ],
            [
                'id_uk' => 'UK2',
            ],
            [
                'id_uk' => 'UK3',
            ],

        ];

        foreach ($data as $item) {
            Apl02::create($item);
        }
    }
}
