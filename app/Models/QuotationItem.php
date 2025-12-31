<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
     protected $fillable = [
        'quotation_id',
        'item_type',
        'item_id',
        'item_name',
        'quantity',
        'unit_price',
        'subtotal',
        'notes',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal'   => 'decimal:2',
        'quantity'   => 'integer',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'item_id')->where('id', $this->item_type === 'product' ? $this->item_id : null);
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'item_id')->where('id', $this->item_type === 'service' ? $this->item_id : null);
    }
    public function getItemNameAttribute($value)
    {
        if ($this->item_type === 'product' && $this->product) {
            return $this->product->name;
        }

        if ($this->item_type === 'service' && $this->service) {
            return $this->service->name;
        }

        return $value;
    }
}
