<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artwork_saves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('artwork_id')->constrained('artworks')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'artwork_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artwork_saves');
    }
};