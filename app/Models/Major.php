<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = [
        'code',
        'name',
        'head_teacher_id',
        'description',
        'is_active',
    ];

    public function headTeacher()
    {
        return $this->belongsTo(User::class, 'head_teacher_id');
    }
}
