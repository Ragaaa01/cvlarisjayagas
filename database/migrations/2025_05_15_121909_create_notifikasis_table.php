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
       Schema::create('notifikasis', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->unsignedBigInteger('id_tagihan');
            $table->unsignedBigInteger('id_template');
            $table->date('tanggal_terjadwal');
            $table->boolean('status_baca');
            $table->dateTime('waktu_dikirim');
            $table->timestamps();

            $table->foreign('id_tagihan')->references('id_tagihan')->on('tagihans')->onDelete('cascade');
            $table->foreign('id_template')->references('id_template')->on('notifikasi_templates')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
