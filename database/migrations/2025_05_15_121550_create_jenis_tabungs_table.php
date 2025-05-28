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
        Schema::create('jenis_tabungs', function (Blueprint $table) {
            $table->id('id_jenis_tabungs');
            $table->string('kode_jenis');
            $table->string('nama_jenis');
            $table->unsignedBigInteger('harga');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_tabungs');
    }
};
