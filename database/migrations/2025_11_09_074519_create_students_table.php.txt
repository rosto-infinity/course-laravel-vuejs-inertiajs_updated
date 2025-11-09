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
        Schema::create('students', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('sexe', ['male', 'female', 'other']);
            $table->json('programs')->nullable(); // ['php', 'js', 'html', 'typescript', 'vuejs', 'nuxtjs']
            $table->string('profile')->nullable(); // Chemin image
            $table->string('country')->nullable();
            $table->enum('language', ['fr', 'en'])->default('fr');
            $table->text('bio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

