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
    Schema::create('volume', function (Blueprint $table) {
        $table->id();
        $table->foreignId('komik_id')->constrained('komik'); // Adding the foreign key
        $table->string('judul_volume');
        $table->string('jumlah_halaman');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volumes');
    }
};
