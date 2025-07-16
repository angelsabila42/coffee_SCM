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
            $table->unsignedBigInteger('transporter_id')->nullable()->after('id');

            // Assuming you have a transporters table and want to set up a foreign key
            $table->foreign('transporter_id')
                ->references('id')
                ->on('transporters')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['transporter_id']);
            $table->dropColumn('transporter_id');
        });
    }
};
