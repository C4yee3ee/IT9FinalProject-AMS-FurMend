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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('pet_name', 100)->nullable()->after('notes');
            $table->string('pet_species', 100)->nullable()->after('pet_name');
            $table->string('pet_breed', 100)->nullable()->after('pet_species');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['pet_name', 'pet_species', 'pet_breed']);
        });
    }
};
