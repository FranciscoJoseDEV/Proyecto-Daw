<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->unique();
            $table->string('description');
            $table->integer('points')->default(0); // Puntos por el logro
            $table->string('condition')->nullable(); // Ejemplo: 'streak:5'
        });

        // Tabla pivote para logros desbloqueados por usuarios
        Schema::create('achievement_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('achievement_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('achieve_date'); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievement_user');
        Schema::dropIfExists('achievements');
    }
};
