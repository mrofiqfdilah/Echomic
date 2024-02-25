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
    Schema::create('gambar_komik', function (Blueprint $table) {
        $table->id();
        $table->foreignId('volume_id')->constrained('volume'); // Adding foreign key for volume
        $table->foreignId('komik_id')->constrained('komik');   // Adding foreign key for komik
        $table->string('judul_gambar');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gambar_komiks');
    }
};
