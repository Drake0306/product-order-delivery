<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'restaurant_id',
        'category_id',
        'name',
        'description',
        'price',
        'inventory',
        'image_url',
    ];

    // A product belongs to a tenant.
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // A product can belong to a restaurant/store.
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    // A product belongs to a category.
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Order items can reference a product.
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
