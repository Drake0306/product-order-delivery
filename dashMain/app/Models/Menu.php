<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'title',
        'description',
    ];

    // A menu belongs to a restaurant.
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    // A menu has many menu items.
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
}
