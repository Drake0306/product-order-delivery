<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'restaurant_id',
        'total_amount',
        'status',
        'order_date',
        'delivery_date',
        'order_type',
    ];

    // An order belongs to a tenant.
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // An order is placed by a user.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An order may belong to a restaurant.
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    // An order has many order items.
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // An order has one delivery.
    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    // An order has one payment.
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
