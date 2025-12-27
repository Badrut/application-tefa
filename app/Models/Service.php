<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'code',
        'name',
        'major_id',
        'description',
        'base_price',
        'service_level',
        'unit',
        'estimated_hours',
        'is_active',
    ];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function files()
    {
        return $this->morphMany(FileUpload::class, 'reference');
    }

    public function primaryImage()
    {
        return $this->morphOne(FileUpload::class, 'reference')
                    ->where('is_primary', true);
    }
}
