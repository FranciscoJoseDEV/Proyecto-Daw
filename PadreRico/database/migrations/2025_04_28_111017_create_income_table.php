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
        Schema::create('income', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->float('amount');
            $table->date('date');
            $table->string('type');
            $table->timestamps();
 
            // Definir la clave foránea
            $table->unsignedBigInteger('user_id'); // Clave foránea

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income');
    }
};
