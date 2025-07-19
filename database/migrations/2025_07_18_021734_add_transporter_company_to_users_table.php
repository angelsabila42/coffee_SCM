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
            if (!Schema::hasColumn('users', 'transporter_company')) {
                $table->string('transporter_company')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'transporter_company_id')) {
                $table->unsignedBigInteger('transporter_company_id')->nullable()->after('transporter_company');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['transporter_company', 'transporter_company_id']);
        });
    }
};
