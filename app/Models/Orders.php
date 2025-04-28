<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orders extends Model
{
    protected $fillable = [
        'order_code',
        'order_date',
        'order_amount',
        'payment_amount',
        'order_status',
        'order_change'
    ];
    public function OrdersDetails()
    {
        return $this->HasMany(OrdersDetails::class, 'order_id', 'id');
    }
    public function product()
    {
        return $this->HasMany(Products::class, 'product_id', 'id');
    }
}
