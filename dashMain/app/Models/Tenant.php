<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subscription_plan',
        'settings',
    ];

    // A tenant can have many users.
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // A tenant can have many restaurants/vendors.
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    // A tenant can have many categories.
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    // A tenant can have many products.
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // A tenant can have many orders.
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // A tenant can have many payments.
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // A tenant can have many addresses.
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    // A tenant can have many reviews.
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // A tenant can have many audit logs.
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }
}
