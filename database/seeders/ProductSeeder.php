<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Major;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
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

        $produkMesin   = Category::where('category_name', 'Produk Mesin')->first();
        $tekstil       = Category::where('category_name', 'Tekstil & Kain')->first();
        $bengkel       = Category::where('category_name', 'Jasa Perbengkelan')->first();
        $website       = Category::where('category_name', 'Website')->first();
        $aplikasi      = Category::where('category_name', 'Aplikasi')->first();

        Product::insert([
            [
                'code' => 'PRD-M-001',
                'name' => 'Rak Besi Las',
                'category_id' => $produkMesin->id,
                'major_id' => $mesin->id,
                'description' => 'Rak besi hasil praktik pengelasan siswa Teknik Mesin.',
                'base_price' => 750000,
                'unit' => 'pcs',
                'is_active' => true,
            ],
            [
                'code' => 'PRD-M-002',
                'name' => 'Meja Kerja Workshop',
                'category_id' => $produkMesin->id,
                'major_id' => $mesin->id,
                'description' => 'Meja kerja besi untuk kebutuhan bengkel dan workshop.',
                'base_price' => 1250000,
                'unit' => 'pcs',
                'is_active' => true,
            ],
            [
                'code' => 'PRD-T-001',
                'name' => 'Kain Tenun Handmade',
                'category_id' => $tekstil->id,
                'major_id' => $perkainan->id,
                'description' => 'Kain tenun handmade hasil produksi siswa.',
                'base_price' => 350000,
                'unit' => 'meter',
                'is_active' => true,
            ],
            [
                'code' => 'PRD-T-002',
                'name' => 'Tas Kain Tenun',
                'category_id' => $tekstil->id,
                'major_id' => $perkainan->id,
                'description' => 'Tas berbahan kain tenun buatan siswa.',
                'base_price' => 275000,
                'unit' => 'pcs',
                'is_active' => true,
            ],
            [
                'code' => 'PRD-O-001',
                'name' => 'Paket Tune Up Ringan',
                'category_id' => $bengkel->id,
                'major_id' => $ototronik->id,
                'description' => 'Paket perawatan dan pengecekan kendaraan ringan.',
                'base_price' => 100000,
                'unit' => 'paket',
                'is_active' => true,
            ],
            [
                'code' => 'PRD-R-001',
                'name' => 'Website Company Profile',
                'category_id' => $website->id,
                'major_id' => $rpl->id,
                'description' => 'Website company profile sederhana untuk UMKM.',
                'base_price' => 1500000,
                'unit' => 'paket',
                'is_active' => true,
            ],
            [
                'code' => 'PRD-R-002',
                'name' => 'Aplikasi Kasir Sederhana',
                'category_id' => $aplikasi->id,
                'major_id' => $rpl->id,
                'description' => 'Aplikasi kasir sederhana berbasis web / desktop.',
                'base_price' => 2500000,
                'unit' => 'paket',
                'is_active' => true,
            ],
        ]);
    }
}
