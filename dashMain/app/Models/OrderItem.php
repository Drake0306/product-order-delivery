<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'menu_item_id',
        'product_id',
        'quantity',
        'price_at_order',
    ];

    // Each order item belongs to an order.
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // If ordered item is a menu item.
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }

    // If ordered item is a product.
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
