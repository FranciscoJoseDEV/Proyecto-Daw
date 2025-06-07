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
            $table->unsignedBigInteger('debtor_user_id'); 
            $table->unsignedBigInteger('beneficiary_user_id'); 
            $table->string('description');
            $table->decimal('amount', 10, 2); 
            $table->date('inicial_date');
            $table->date('due_date'); 
            $table->integer('accepted')->default(0); // 0: No aceptado, 1: Aceptado
            $table->timestamps();

            // Relación con la tabla users (deudor)
            $table->foreign('debtor_user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Relación con la tabla users (beneficiario)
            $table->foreign('beneficiary_user_id')->references('id')->on('users')->onDelete('cascade');
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
