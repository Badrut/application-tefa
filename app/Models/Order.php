<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_code',
        'customer_id',
        'quotation_id',
        'major_id',
        'order_date',
        'total_amount',
        'payment_status',
        'order_status',
        'delivery_address',
        'delivery_date',
        'notes',
    ];

    protected $casts = [
        'order_date'    => 'date',
        'delivery_date' => 'date',
        'total_amount'  => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function itemsOrder()
    {
        return $this->hasMany(OrderItem::class)->whereNotNull('item_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
