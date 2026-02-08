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
        Schema::table('kt_transaksi', function (Blueprint $table) {
            // hapus FK & kolom id_users
            $table->dropForeign(['id_users']);
            $table->dropColumn('id_users');

            // tambah customer text
            $table->string('customer')->nullable()->after('id_supplier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kt_transaksi', function (Blueprint $table) {
            // hapus customer
            $table->dropColumn('customer');

            // balikin id_users
            $table->unsignedBigInteger('id_users');

            $table->foreign('id_users')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
};
