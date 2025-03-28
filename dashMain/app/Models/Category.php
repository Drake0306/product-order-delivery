<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'description',
    ];

    // A category belongs to a tenant.
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // A category can have many products.
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
