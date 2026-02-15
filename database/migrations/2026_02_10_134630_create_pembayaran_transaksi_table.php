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
        Schema::create('pembayaran_transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_transaksi')
                ->constrained('kt_transaksi')
                ->cascadeOnDelete();

            $table->date('tanggal_bayar');
            $table->decimal('jumlah_bayar', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_transaksi');
    }
};
