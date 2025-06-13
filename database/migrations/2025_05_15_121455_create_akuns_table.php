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
        Schema::create('akuns', function (Blueprint $table) {
            $table->id('id_akun');
            $table->unsignedBigInteger('id_perorangan')->nullable()->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['administrator', 'pelanggan'])->default('pelanggan');
            $table->boolean('status_aktif')->default(false);
            $table->string('remember_token')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_perorangan')->references('id_perorangan')->on('perorangans')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akuns');
    }
};
