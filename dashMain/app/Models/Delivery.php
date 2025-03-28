<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'driver_id',
        'status',
        'estimated_delivery_time',
        'actual_delivery_time',
        'tracking_info',
    ];

    // A delivery belongs to an order.
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // The driver (user) handling the delivery.
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
