<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'address',
        'contact_info',
        'operating_hours',
    ];

    // A restaurant belongs to a tenant.
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // A restaurant can have many menus.
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    // A restaurant can be linked to many products.
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // A restaurant can have many orders.
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // A restaurant might have an address.
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
