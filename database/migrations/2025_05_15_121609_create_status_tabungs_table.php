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
        Schema::create('status_tabungs', function (Blueprint $table) {
            $table->id('id_status_tabung');
            $table->enum('status_tabung', ['tersedia', 'dipinjam', 'rusak', 'hilang']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_tabungs');
    }
};
