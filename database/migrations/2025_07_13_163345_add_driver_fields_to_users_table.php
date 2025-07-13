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
        Schema::table('users', function (Blueprint $table) {
            // Only add columns that don't exist
            if (!Schema::hasColumn('users', 'license_number')) {
                $table->string('license_number')->nullable();
            }
            if (!Schema::hasColumn('users', 'vehicle_number')) {
                $table->string('vehicle_number')->nullable();
            }
            if (!Schema::hasColumn('users', 'experience')) {
                $table->string('experience')->nullable();
            }
            if (!Schema::hasColumn('users', 'is_available')) {
                $table->boolean('is_available')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'address', 'license_number', 
                'vehicle_number', 'experience', 'is_available'
            ]);
        });
    }
};
