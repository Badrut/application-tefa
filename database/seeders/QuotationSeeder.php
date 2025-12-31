<?php

namespace Database\Seeders;

use App\Models\Quotation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuotationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Quotation::create([
            'quotation_code' => 'QT-001',
            'consultation_id' => 1,
            'customer_id' => 1,
            'total_amount' => 15000000,
            'valid_until'     => now()->addDays(14)->toDateString(),
            'status' => 'sent',
            'created_by' => 2,
        ]);
    }
}
