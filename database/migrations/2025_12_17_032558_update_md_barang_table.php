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
        Schema::table('md_barang', function (Blueprint $table) {
            $table->foreignId('merek_id')
                  ->constrained('md_merek')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('md_barang', function (Blueprint $table) {
            $table->dropForeign(['merek_id']);
            $table->dropColumn('merek_id');
        });
    }
};
