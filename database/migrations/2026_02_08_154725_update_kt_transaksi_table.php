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
            if (Schema::hasColumn('kt_transaksi', 'id_users')) {
                $table->dropForeign(['id_users']);
                $table->dropColumn('id_users');
            }
            $table->string('customer')->nullable()->after('id_supplier');
            $table->date('jatuh_tempo')->nullable()->after('tanggal');
            $table->enum('status_pembayaran', ['BELUM_LUNAS', 'LUNAS'])
                ->default('BELUM_LUNAS')
                ->after('total_bayar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kt_transaksi', function (Blueprint $table) {
            $table->dropColumn([
                'customer',
                'jatuh_tempo',
                'status_pembayaran'
            ]);

            // balikin id_users
            $table->unsignedBigInteger('id_users')->nullable();

            $table->foreign('id_users')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
};
