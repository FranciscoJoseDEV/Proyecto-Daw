<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Trigger para la tabla income
        DB::statement('
            CREATE TRIGGER actualizar_saldo_income
            AFTER INSERT ON income
            FOR EACH ROW
            BEGIN
                UPDATE users
                SET savings = savings + NEW.amount
                WHERE id = NEW.user_id;
            END
        ');

        // Trigger para la tabla outcome
        DB::statement('
            CREATE TRIGGER actualizar_saldo_outcome
            AFTER INSERT ON outcome
            FOR EACH ROW
            BEGIN
                UPDATE users
                SET savings = savings - NEW.amount
                WHERE id = NEW.user_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar los triggers
        DB::statement('DROP TRIGGER IF EXISTS actualizar_saldo_income');
        DB::statement('DROP TRIGGER IF EXISTS actualizar_saldo_outcome');
    }
};
