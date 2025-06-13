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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->unsignedBigInteger('id_akun')->nullable();
            $table->unsignedBigInteger('id_perorangan')->nullable();
            $table->unsignedBigInteger('id_perusahaan')->nullable();
            $table->date('tanggal_transaksi');
            $table->time('waktu_transaksi');
            $table->unsignedBigInteger('jumlah_dibayar');
            $table->enum('metode_pembayaran', ['transfer', 'tunai']);
            $table->unsignedBigInteger('id_status_transaksi');
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->timestamps();

            $table->foreign('id_akun')->references('id_akun')->on('akuns')->onDelete('set null');
            $table->foreign('id_perorangan')->references('id_perorangan')->on('perorangans')->onDelete('set null');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaans')->onDelete('set null');
            $table->foreign('id_status_transaksi')->references('id_status_transaksi')->on('status_transaksis')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
