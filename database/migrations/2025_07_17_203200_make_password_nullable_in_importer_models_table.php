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
        Schema::table('importer_models', function (Blueprint $table) {
<<<<<<< HEAD:database/migrations/2025_07_11_141622_drop_password_from_importer_models.php
           $table->dropColumn('password');
=======
            $table->string('password')->nullable()->change();
>>>>>>> fb2d4048f48f4293edaa322d545dc7006863a104:database/migrations/2025_07_17_203200_make_password_nullable_in_importer_models_table.php
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('importer_models', function (Blueprint $table) {
<<<<<<< HEAD:database/migrations/2025_07_11_141622_drop_password_from_importer_models.php
             $table->string('password');
=======
            $table->string('password')->nullable(false)->change();
>>>>>>> fb2d4048f48f4293edaa322d545dc7006863a104:database/migrations/2025_07_17_203200_make_password_nullable_in_importer_models_table.php
        });
    }
};
