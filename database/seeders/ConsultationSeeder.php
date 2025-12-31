<?php

namespace Database\Seeders;

use App\Models\Consultation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Consultation::create([
            'consultation_code' => 'CONS-001',
            'customer_id' => 1,
            'major_id' => 1,
            'subject' => 'Konsultasi pembuatan mesin produksi',
            'status' => 'in_progress',
            'assigned_teacher_id' => 2,
        ]);
    }
}
