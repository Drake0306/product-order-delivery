<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuditLog extends Model
{
    use HasFactory;

    public $timestamps = false; // using only created_at

    protected $fillable = [
        'tenant_id',
        'user_id',
        'action_type',
        'description',
        'created_at',
    ];

    // An audit log belongs to a tenant.
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // An audit log may belong to a user.
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
