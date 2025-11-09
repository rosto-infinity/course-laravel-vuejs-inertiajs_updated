<?php

declare(strict_types=1);

use App\Enums\Language;
use App\Enums\Sexe;
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
            $table->enum('sexe', Sexe::values());
            $table->json('programs')->nullable();
            $table->string('profile')->nullable();
            $table->string('country')->nullable();
            $table->enum('language', Language::values())->default(Language::FR->value);
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
