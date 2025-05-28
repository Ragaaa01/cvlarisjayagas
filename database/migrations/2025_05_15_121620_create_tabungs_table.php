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
        Schema::create('tabungs', function (Blueprint $table) {
            $table->id('id_tabung');
            $table->string('kode_tabung');
            $table->unsignedBigInteger('id_jenis_tabung');
            $table->unsignedBigInteger('id_status_tabung');
            $table->timestamps();

            $table->foreign('id_jenis_tabung')->references('id_jenis_tabungs')->on('jenis_tabungs')->onDelete('cascade');
            $table->foreign('id_status_tabung')->references('id_status_tabung')->on('status_tabungs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabungs');
    }
};
