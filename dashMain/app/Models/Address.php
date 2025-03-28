<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'restaurant_id',
        'street',
        'city',
        'state',
        'zip',
        'country',
        'latitude',
        'longitude',
    ];

    // An address belongs to a tenant.
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // An address may belong to a user.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Or it may belong to a restaurant.
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
