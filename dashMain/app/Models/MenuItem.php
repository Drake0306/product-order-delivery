<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'name',
        'description',
        'price',
        'image_url',
        'availability',
    ];

    // A menu item belongs to a menu.
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    // Order items can reference a menu item.
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
