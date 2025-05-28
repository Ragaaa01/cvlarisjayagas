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
       Schema::create('peminjamans', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->unsignedBigInteger('id_detail_transaksi');
            $table->date('tanggal_pinjam');
            $table->enum('status_pinjam', ['aktif', 'selesai']);
            $table->timestamps();

            $table->foreign('id_detail_transaksi')->references('id_detail_transaksi')->on('detail_transaksis')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
