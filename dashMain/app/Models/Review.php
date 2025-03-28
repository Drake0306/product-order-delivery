<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'order_id',
        'user_id',
        'rating',
        'comment',
    ];

    // A review belongs to a tenant.
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // A review can be for an order.
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // A review belongs to a user.
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
