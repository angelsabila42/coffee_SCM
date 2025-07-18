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
        Schema::table('vendor', function (Blueprint $table) {
            $table->string('Bank_account');
            $table->string('Account_holder');
            $table->string('Bank_name');
             //$table->dropColumn('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor', function (Blueprint $table) {
            $table->dropColumn(['Bank_account', 'Account_holder', 'Bank_name']);
        });
    }
};
