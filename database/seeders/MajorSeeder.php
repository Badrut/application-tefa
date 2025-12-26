<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Major::insert([
            [
                'code' => 'M',
                'name' => 'Teknik Mesin',
                'description' => 'Jurusan yang mempelajari tentang mesin dan peralatan mekanik.',
                'is_active' => true,
            ],
            [
                'code' => 'T',
                'name' => 'Teknik Perkainan',
                'description' => 'Jurusan yang mempelajari tentang teknologi perikanan dan kelautan.',
                'is_active' => true,
            ],
            [
                'code' => 'O',
                'name' => 'Teknik Otrotonik',
                'description' => 'Jurusan yang mempelajari tentang otomotif dan kendaraan bermotor.',
                'is_active' => true,
            ],
            [
                'code' => 'R',
                'name' => 'Rekayasa Perangkat Lunak',
                'description' => 'Jurusan yang mempelajari tentang pengembangan perangkat lunak dan aplikasi.',
                'is_active' => true,
            ]
        ]);
    }
}
