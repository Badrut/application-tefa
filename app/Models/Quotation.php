<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quotation extends Model {

    protected $fillable = [
        'quotation_code',
        'consultation_id',
        'customer_id',
        'total_amount',
        'valid_until',
        'status',
        'created_by',
    ];

    protected $casts = [
        'valid_until' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // kalau nanti dipakai
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
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
