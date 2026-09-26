<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actor_film', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actor_id');
            $table->unsignedBigInteger('film_id'); // must match 'film.id'

            $table->timestamps();

            $table->foreign('actor_id')->references('id')->on('actors')->onDelete('cascade');
            $table->foreign('film_id')->references('id')->on('film')->onDelete('cascade'); // ← use 'film' not 'films'
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('actor_film');
    }
};
