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
            $table->string('genral_balance')->unique();
            $table->string('income_vs_outcome');
            $table->string('outcome_category');
            $table->string('most_spending_day');
            $table->string('active_suscriptions');
            $table->string('expenses_alert');
            $table->string('M_or_W');
            $table->string('serial');
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
