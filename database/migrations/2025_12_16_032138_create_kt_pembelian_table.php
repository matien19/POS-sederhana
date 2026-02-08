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
        Schema::create('kt_pembelian', function (Blueprint $table) {
            $table->id(); // id_pembelian (PK)

            $table->unsignedBigInteger('id_transaksi'); // FK ke kt_transaksi
            $table->date('tanggal');

            $table->unsignedBigInteger('id_barang'); // FK ke md_barang

            $table->decimal('harga_satuan', 15, 2);
            $table->integer('jumlah_beli');
            $table->decimal('subtotal', 15, 2);

            $table->timestamps();

            // Foreign Key
            $table->foreign('id_transaksi')
                  ->references('id')
                  ->on('kt_transaksi')
                  ->onDelete('cascade');

            $table->foreign('id_barang')
                  ->references('id')
                  ->on('md_barang')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kt_pembelian');
    }
};
