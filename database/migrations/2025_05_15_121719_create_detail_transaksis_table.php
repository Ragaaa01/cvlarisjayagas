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
        Schema::create('detail_transaksis', function (Blueprint $table) {
    $table->id('id_detail_transaksi');
    $table->unsignedBigInteger('id_transaksi');
    $table->unsignedBigInteger('id_tabung');
    $table->unsignedBigInteger('id_jenis_transaksi');
    $table->unsignedBigInteger('harga');
    $table->date('batas_waktu_peminjaman')->nullable();
    $table->timestamps();

    $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksis')->onDelete('cascade');
    $table->foreign('id_tabung')->references('id_tabung')->on('tabungs')->onDelete('cascade');
    $table->foreign('id_jenis_transaksi')->references('id_jenis_transaksi')->on('jenis_transaksis')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
