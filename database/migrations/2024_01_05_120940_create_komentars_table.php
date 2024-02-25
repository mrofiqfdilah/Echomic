<?php

// database/migrations/{timestamp}_create_komentars_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomentarsTable extends Migration
{
    public function up()
    {
        Schema::create('komentars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('komik_id');
            $table->unsignedBigInteger('volume_id');
            $table->text('komentar');
            $table->unsignedInteger('rating');
            $table->timestamps();

            // Define foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('komik_id')->references('id')->on('komiks')->onDelete('cascade');
            $table->foreign('volume_id')->references('id')->on('volumes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('komentars');
    }
}
