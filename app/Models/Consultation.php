<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model {
    protected $fillable = [
        'consultation_code',
        'customer_id',
        'major_id',
        'subject',
        'status',
        'assigned_teacher_id'
    ];

    public function messages() {
        return $this->hasMany(ChatMessage::class);
    }

    public function quotation() {
        return $this->hasOne(Quotation::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'assigned_teacher_id');
    }
}
