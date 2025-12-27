<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'category_name' => 'Teknik & Manufaktur',
                'parent_category_id' => null,
                'is_active' => true,
            ],
            [
                'category_name' => 'IT & Digital',
                'parent_category_id' => null,
                'is_active' => true,
            ],
            [
                'category_name' => 'Produk Mesin',
                'parent_category_id' => 1,
                'is_active' => true,
            ],
            [
                'category_name' => 'Jasa Perbengkelan',
                'parent_category_id' => 1,
                'is_active' => true,
            ],
            [
                'category_name' => 'Tekstil & Kain',
                'parent_category_id' => 1,
                'is_active' => true,
            ],
            [
                'category_name' => 'Website',
                'parent_category_id' => 2,
                'is_active' => true,
            ],
            [
                'category_name' => 'Aplikasi',
                'parent_category_id' => 2,
                'is_active' => true,
            ],
            [
                'category_name' => 'Jasa IT',
                'parent_category_id' => 2,
                'is_active' => true,
            ],
        ]);
    }
}
