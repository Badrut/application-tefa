<?php

namespace Database\Seeders;

use App\Models\ChatMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChatMessage::create([
            'consultation_id' => 1,
            'sender_id' => 1,
            'message_text' => 'Saya butuh mesin custom sesuai kebutuhan produksi',
            'sent_at' => now(),
        ]);

        ChatMessage::create([
            'consultation_id' => 1,
            'sender_id' => 2,
            'message_text' => 'Baik, kami analisa dulu kebutuhannya',
            'sent_at' => now(),
        ]);
    }
}
