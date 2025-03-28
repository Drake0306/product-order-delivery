<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TenantAndSuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Create a default tenant
        $tenant = Tenant::create([
            'name' => 'Default Tenant',
            'subscription_plan' => 'enterprise',
            'settings' => json_encode([
                'theme' => 'default',
                // Add additional tenant-specific settings here
            ]),
        ]);

        // Create a super admin user for the tenant
        User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'), // Use a secure password in production
            'phone' => '1234567890',
            'role' => 'super_admin', // Ensure this role matches your admin role
        ]);
    }
}
