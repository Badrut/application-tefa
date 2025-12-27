<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mesin     = Major::where('code', 'M')->first();
        $perkainan = Major::where('code', 'T')->first();
        $ototronik = Major::where('code', 'O')->first();
        $rpl       = Major::where('code', 'R')->first();

         Service::insert([
            [
                'code' => 'SRV-M-001',
                'name' => 'Pembuatan Komponen Mesin Sederhana',
                'major_id' => $mesin->id,
                'description' => 'Jasa pembuatan komponen mesin sederhana oleh siswa.',
                'base_price' => 200000,
                'service_level' => 'ringan',
                'unit' => 'paket',
                'estimated_hours' => 48,
                'is_active' => true,
            ],
            [
                'code' => 'SRV-M-002',
                'name' => 'Pengelasan Rangka Besi',
                'major_id' => $mesin->id,
                'description' => 'Jasa pengelasan rangka besi skala kecil.',
                'base_price' => 350000,
                'service_level' => 'sedang',
                'unit' => 'paket',
                'estimated_hours' => 72,
                'is_active' => true,
            ],
            [
                'code' => 'SRV-T-001',
                'name' => 'Produksi Kain Tenun Custom',
                'major_id' => $perkainan->id,
                'description' => 'Produksi kain tenun sesuai permintaan pelanggan.',
                'base_price' => 300000,
                'service_level' => 'sedang',
                'unit' => 'paket',
                'estimated_hours' => 96,
                'is_active' => true,
            ],
            [
                'code' => 'SRV-O-001',
                'name' => 'Diagnosa Kendaraan Ringan',
                'major_id' => $ototronik->id,
                'description' => 'Pengecekan dan diagnosa kondisi kendaraan.',
                'base_price' => 25000,
                'service_level' => 'diagnosa',
                'unit' => 'paket',
                'estimated_hours' => 8,
                'is_active' => true,
            ],
            [
                'code' => 'SRV-O-002',
                'name' => 'Servis Ringan Kendaraan',
                'major_id' => $ototronik->id,
                'description' => 'Servis ringan kendaraan bermotor.',
                'base_price' => 100000,
                'service_level' => 'ringan',
                'unit' => 'paket',
                'estimated_hours' => 24,
                'is_active' => true,
            ],
            [
                'code' => 'SRV-R-001',
                'name' => 'Pembuatan Website Sederhana',
                'major_id' => $rpl->id,
                'description' => 'Jasa pembuatan website sederhana untuk UMKM.',
                'base_price' => 1200000,
                'service_level' => 'sedang',
                'unit' => 'paket',
                'estimated_hours' => 120,
                'is_active' => true,
            ],
            [
                'code' => 'SRV-R-002',
                'name' => 'Maintenance Website',
                'major_id' => $rpl->id,
                'description' => 'Jasa perawatan dan perbaikan website.',
                'base_price' => 500000,
                'service_level' => 'ringan',
                'unit' => 'paket',
                'estimated_hours' => 40,
                'is_active' => true,
            ],
        ]);
    }
}
