<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code',
        'name',
        'category_id',
        'major_id',
        'description',
        'base_price',
        'unit',
        'is_active',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

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
