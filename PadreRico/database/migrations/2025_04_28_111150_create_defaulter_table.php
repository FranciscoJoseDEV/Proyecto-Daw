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
        Schema::create('defaulters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Clave foránea
            $table->string('name');
            $table->string('email')->unique();
            $table->string('description');
            $table->decimal('amount', 10, 2); // Cambiado a decimal para cantidades monetarias
            $table->date('inicial_date'); // Fecha inicial
            $table->date('due_date'); // Fecha de vencimiento
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('defaulters');
    }
};
