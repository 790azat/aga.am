<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('film', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('genres')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->integer('year')->nullable();
            $table->string('director')->nullable();
            $table->string('producer')->nullable();
            $table->string('poster')->nullable();
            $table->string('background')->nullable();
            $table->string('logo')->nullable();
            $table->string('video')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('rating', 2, 1)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('film');
    }
};


