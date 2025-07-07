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
        Schema::table('payments',function(Blueprint $table){
            
            if(!Schema::hasColumn('payments','importerID')){
                $table->unsignedBigInteger('importerID')->nullable();
            }

            $table->foreign('importerID')->references('id')->on('importer_models')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments',function(Blueprint $table){
            $table->dropForeign('id');
        });
    }
};
