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
        Schema::create('savings_objective', function (Blueprint $table) {
            $table->id();
            $table->string('objective_name');
            $table->float('goal_amount');
            $table->date('date_limit');
            $table->string('status');
            $table->timestamps();

            $table->unsignedBigInteger('user_id'); // Clave foránea

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('savings_objective');
    }
};
