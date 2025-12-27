<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    protected $fillable = [
        'reference_type',
        'reference_id',
        'file_path',
        'file_name',
        'file_type',
        'mime_type',
        'size',
        'is_primary',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'is_primary' => 'boolean',
    ];

    public function reference()
    {
        return $this->morphTo();
    }
}
