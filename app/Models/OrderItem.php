<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'item_type',
        'item_id',
        'quantity',
        'unit_price',
        'discount',
        'subtotal',
        'specifications',
    ];

    protected $casts = [
        'unit_price'     => 'decimal:2',
        'discount'       => 'decimal:2',
        'subtotal'       => 'decimal:2',
        'quantity'       => 'integer',
        'specifications' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function item()
    {
        return $this->morphTo(null, 'item_type', 'item_id');
    }
}
