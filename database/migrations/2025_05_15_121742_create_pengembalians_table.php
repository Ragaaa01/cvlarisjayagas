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
         Schema::create('pengembalians', function (Blueprint $table) {
            $table->id('id_pengembalian');
            $table->unsignedBigInteger('id_peminjaman');
            $table->date('tanggal_kembali');
            $table->enum('kondisi_tabung', ['baik', 'rusak']);
            $table->string('keterangan');
            $table->timestamps();

            $table->foreign('id_peminjaman')->references('id_peminjaman')->on('peminjamans')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
