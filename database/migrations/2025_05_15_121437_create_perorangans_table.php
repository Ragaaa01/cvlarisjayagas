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
        Schema::create('perorangans', function (Blueprint $table) {
            $table->id('id_perorangan');
            $table->string('nama_lengkap');
            $table->string('nik')->unique();
            $table->string('no_telepon')->unique();
            $table->text('alamat');
            $table->unsignedBigInteger('id_perusahaan')->nullable();
            $table->timestamps();

            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaans')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perorangans');
    }
};
