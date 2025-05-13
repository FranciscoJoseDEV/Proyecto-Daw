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
                UPDATE users
                SET savings = savings + NEW.amount
                WHERE id = NEW.user_id;
            END
        ');

        // INCOME: DELETE → resta de savings
        DB::unprepared('
            CREATE TRIGGER after_delete_income
            AFTER DELETE ON income
            FOR EACH ROW
            BEGIN
                UPDATE users
                SET savings = savings - OLD.amount
                WHERE id = OLD.user_id;
            END
        ');

        // INCOME: UPDATE → revierte old y aplica new
        DB::unprepared('
            CREATE TRIGGER after_update_income
            AFTER UPDATE ON income
            FOR EACH ROW
            BEGIN
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
            END
        ');

        // OUTCOME: INSERT → resta de savings
        DB::unprepared('
            CREATE TRIGGER after_insert_outcome
            AFTER INSERT ON outcome
            FOR EACH ROW
            BEGIN
                UPDATE users
                SET savings = savings - NEW.amount
                WHERE id = NEW.user_id;
            END
        ');

        // OUTCOME: DELETE → suma a savings
        DB::unprepared('
            CREATE TRIGGER after_delete_outcome
            AFTER DELETE ON outcome
            FOR EACH ROW
            BEGIN
                UPDATE users
                SET savings = savings + OLD.amount
                WHERE id = OLD.user_id;
            END
        ');

        // OUTCOME: UPDATE → revierte old y aplica new
        DB::unprepared('
            CREATE TRIGGER after_update_outcome
            AFTER UPDATE ON outcome
            FOR EACH ROW
            BEGIN
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
    }
};
