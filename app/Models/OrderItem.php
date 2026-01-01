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
