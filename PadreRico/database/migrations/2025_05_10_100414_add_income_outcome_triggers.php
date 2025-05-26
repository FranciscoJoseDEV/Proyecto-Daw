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
        // INCOME: INSERT → suma a savings
        DB::unprepared('
            CREATE TRIGGER after_insert_income
            AFTER INSERT ON income
            FOR EACH ROW
            BEGIN
                IF NEW.recurrent = 0 THEN
                    UPDATE users
                    SET savings = savings + NEW.amount
                    WHERE id = NEW.user_id;
                END IF;
            END
        ');

        // INCOME: DELETE → resta de savings
        DB::unprepared('
            CREATE TRIGGER after_delete_income
            AFTER DELETE ON income
            FOR EACH ROW
            BEGIN
                IF OLD.recurrent = 0 THEN
                    UPDATE users
                    SET savings = savings - OLD.amount
                    WHERE id = OLD.user_id;
                END IF;
            END
        ');

        // INCOME: UPDATE → revierte old y aplica new
        DB::unprepared('
            CREATE TRIGGER after_update_income
            AFTER UPDATE ON income
            FOR EACH ROW
            BEGIN
                IF OLD.recurrent = 0 AND NEW.recurrent = 0 THEN
                    IF OLD.user_id != NEW.user_id THEN
                        UPDATE users
                        SET savings = savings - OLD.amount
                        WHERE id = OLD.user_id;

                        UPDATE users
                        SET savings = savings + NEW.amount
                        WHERE id = NEW.user_id;
                    ELSE
                        UPDATE users
                        SET savings = savings - OLD.amount + NEW.amount
                        WHERE id = NEW.user_id;
                    END IF;
                END IF;
            END
        ');

        // OUTCOME: INSERT → resta de savings
        DB::unprepared('
            CREATE TRIGGER after_insert_outcome
            AFTER INSERT ON outcome
            FOR EACH ROW
            BEGIN
                IF NEW.recurrent = 0 THEN
                    UPDATE users
                    SET savings = savings - NEW.amount
                    WHERE id = NEW.user_id;
                END IF;
            END
        ');

        // OUTCOME: DELETE → suma a savings
        DB::unprepared('
            CREATE TRIGGER after_delete_outcome
            AFTER DELETE ON outcome
            FOR EACH ROW
            BEGIN
                IF OLD.recurrent = 0 THEN
                    UPDATE users
                    SET savings = savings + OLD.amount
                    WHERE id = OLD.user_id;
                END IF;
            END
        ');

        // OUTCOME: UPDATE → revierte old y aplica new
        DB::unprepared('
            CREATE TRIGGER after_update_outcome
            AFTER UPDATE ON outcome
            FOR EACH ROW
            BEGIN
                IF OLD.recurrent = 0 AND NEW.recurrent = 0 THEN
                    IF OLD.user_id != NEW.user_id THEN
                        UPDATE users
                        SET savings = savings + OLD.amount
                        WHERE id = OLD.user_id;

                        UPDATE users
                        SET savings = savings - NEW.amount
                        WHERE id = NEW.user_id;
                    ELSE
                        UPDATE users
                        SET savings = savings + OLD.amount - NEW.amount
                        WHERE id = NEW.user_id;
                    END IF;
                END IF;
            END
        ');

        // EVENTO: aplicar ingresos/gastos recurrentes cada mes
        DB::unprepared('
            CREATE EVENT IF NOT EXISTS apply_monthly_recurrents
            ON SCHEDULE EVERY 1 MONTH
            STARTS (TIMESTAMP(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL DAY(CURRENT_DATE) DAY)
            DO
            BEGIN
                -- Aplicar ingresos recurrentes
                UPDATE users u
                JOIN (
                    SELECT user_id, SUM(amount) AS total_income
                    FROM income
                    WHERE recurrent = 1
                    GROUP BY user_id
                ) i ON u.id = i.user_id
                SET u.savings = u.savings + i.total_income;

                -- Aplicar gastos recurrentes
                UPDATE users u
                JOIN (
                    SELECT user_id, SUM(amount) AS total_outcome
                    FROM outcome
                    WHERE recurrent = 1
                    GROUP BY user_id
                ) o ON u.id = o.user_id
                SET u.savings = u.savings - o.total_outcome;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS after_insert_income');
        DB::statement('DROP TRIGGER IF EXISTS after_delete_income');
        DB::statement('DROP TRIGGER IF EXISTS after_update_income');

        DB::statement('DROP TRIGGER IF EXISTS after_insert_outcome');
        DB::statement('DROP TRIGGER IF EXISTS after_delete_outcome');
        DB::statement('DROP TRIGGER IF EXISTS after_update_outcome');

        DB::unprepared('DROP EVENT IF EXISTS apply_monthly_recurrents');
    }
};
