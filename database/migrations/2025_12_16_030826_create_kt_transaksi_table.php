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
        Schema::create('kt_transaksi', function (Blueprint $table) {
        $table->id(); // PK = id

        $table->string('no_transaksi', 50);

        $table->unsignedBigInteger('id_users');
        $table->unsignedBigInteger('id_supplier')->nullable();

        $table->enum('jenis_transaksi', ['pembelian', 'penjualan'])->nullable();
        $table->dateTime('tanggal');

        $table->integer('total_qty');
        $table->decimal('diskon', 15, 2)->default(0);
        $table->decimal('total_bayar', 15, 2);
        $table->decimal('jumlah_bayar', 15, 2);
        $table->decimal('kembalian', 15, 2)->default(0);

        $table->enum('metode_bayar', ['Cash', 'QRIS', 'Debit', 'Transfer']);
        $table->text('keterangan')->nullable();

        $table->timestamps();

        // FK users
        $table->foreign('id_users')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

        // FK supplier
        $table->foreign('id_supplier')
            ->references('id')
            ->on('md_supplier')
            ->onDelete('set null');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kt_transaksi');
    }
};
