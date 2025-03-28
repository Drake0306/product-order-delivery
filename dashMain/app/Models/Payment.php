<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'tenant_id',
        'amount',
        'payment_method',
        'transaction_id',
        'payment_status',
        'paid_at',
    ];

    // A payment belongs to an order.
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // A payment belongs to a tenant.
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
