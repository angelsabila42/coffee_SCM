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
         
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('vendor_id')->nullable()->after('transporter_id');
             $table->foreign('vendor_id')->references('id')->on('vendor')->onDelete('cascade');
         
 });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function(Blueprint $table){
            $table->dropColumn('vendor_id');
        });
    }
};
