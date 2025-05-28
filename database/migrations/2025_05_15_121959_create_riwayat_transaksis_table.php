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
        Schema::create('riwayat_transaksis', function (Blueprint $table) {
            $table->id('id_riwayat_transaksi');
            $table->unsignedBigInteger('id_transaksi');
            $table->unsignedBigInteger('id_akun')->nullable();
            $table->unsignedBigInteger('id_perorangan')->nullable();
            $table->unsignedBigInteger('id_perusahaan')->nullable();
            $table->date('tanggal_transaksi');
            $table->unsignedBigInteger('total_transaksi');
            $table->unsignedBigInteger('jumlah_dibayar');
            $table->enum('metode_pembayaran', ['transfer', 'tunai']);
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status_akhir', ['success', 'failed'])->default('success');
            $table->unsignedBigInteger('total_pembayaran');
            $table->unsignedBigInteger('denda');
            $table->integer('durasi_peminjaman')->nullable();
            $table->string('keterangan');
            $table->timestamps();

            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksis')->onDelete('cascade');
            $table->foreign('id_akun')->references('id_akuns')->on('akuns')->onDelete('set null');
            $table->foreign('id_perorangan')->references('id_perorangan')->on('perorangans')->onDelete('set null');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaans')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_transaksis');
    }
};
