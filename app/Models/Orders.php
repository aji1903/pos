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
    public function orderDetails()
    {
        return $this->hasMany(Orders_Details::class, 'order_id', 'id');
    }
}
