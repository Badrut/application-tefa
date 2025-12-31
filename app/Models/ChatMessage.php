<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'consultation_id',
        'sender_id',
        'message_text',
        'attachment_url',
        'is_read',
        'sent_at',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
