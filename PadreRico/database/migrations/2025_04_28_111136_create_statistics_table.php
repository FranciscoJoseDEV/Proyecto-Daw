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
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->string('general_balance');
            $table->string('income_total');
            $table->string('outcome_total');
            $table->string('outcome_category');
            $table->string('most_spending_day');
            $table->string('most_spending_day_total');
            $table->string('M_or_W');
            $table->string('date');
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
        Schema::dropIfExists('statistics');
    }
};
