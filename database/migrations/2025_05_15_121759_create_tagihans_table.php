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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id('id_tagihan');
            $table->unsignedBigInteger('id_transaksi');
            $table->decimal('jumlah_dibayar', 10, 2);
            $table->decimal('sisa', 10, 2);
            $table->enum('status', ['lunas', 'belum_lunas']);
            $table->date('tanggal_bayar_tagihan')->nullable();
            $table->integer('hari_keterlambatan')->nullable();
            $table->integer('periode_ke')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
