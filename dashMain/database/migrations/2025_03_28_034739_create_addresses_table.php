<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id(); // address_id
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            // Address can belong to a user or a restaurant (vendor)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('restaurant_id')->nullable()->constrained('restaurants')->onDelete('set null');
            $table->string('street');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
