<?php

namespace Database\Seeders;

use App\Models\QuotationItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuotationItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        QuotationItem::create([
            'quotation_id' => 1,
            'item_type' => 'custom',
            'item_id' => null,
            'item_name' => 'Mesin Produksi Custom (Project)',
            'quantity' => 1,
            'unit_price' => 15000000,
            'subtotal' => 15000000,
            'notes' => 'Desain sesuai kebutuhan klien',
        ]);
    }
}
