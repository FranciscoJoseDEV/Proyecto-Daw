<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $logros = [
            // Logros de racha y ahorro (anteriores)
            [
                'name' => '¡Primer día!',
                'description' => 'Completa tu primera racha de 1 día.',
                'points' => 10,
                'condition' => 'streak:1',
            ],
            [
                'name' => 'Racha de 7 días',
                'description' => 'Mantén tu racha durante 7 días seguidos.',
                'points' => 20,
                'condition' => 'streak:7',
            ],
            [
                'name' => 'Racha de 14 días',
                'description' => 'Mantén tu racha durante 14 días seguidos.',
                'points' => 30,
                'condition' => 'streak:14',
            ],
            [
                'name' => 'Racha de 30 días',
                'description' => 'Mantén tu racha durante 30 días seguidos.',
                'points' => 50,
                'condition' => 'streak:30',
            ],
            [
                'name' => 'Racha legendaria',
                'description' => '¡Racha de 100 días! Una hazaña legendaria.',
                'points' => 100,
                'condition' => 'streak:100',
            ],
            [
                'name' => 'Ahorro inicial',
                'description' => 'Alcanza 100 € de ahorro acumulado.',
                'points' => 10,
                'condition' => 'savings:100',
            ],
            [
                'name' => 'Ahorrador constante',
                'description' => 'Llega a 500 € de ahorro.',
                'points' => 20,
                'condition' => 'savings:500',
            ],
            [
                'name' => 'Meta de 1000 €',
                'description' => 'Ahorra al menos 1000 €.',
                'points' => 30,
                'condition' => 'savings:1000',
            ],
            [
                'name' => 'Ahorrador experto',
                'description' => 'Alcanza los 2500 € en tu cuenta.',
                'points' => 50,
                'condition' => 'savings:2500',
            ],
            [
                'name' => 'Ahorro épico',
                'description' => 'Consigue 5000 € de ahorro total.',
                'points' => 100,
                'condition' => 'savings:5000',
            ],
            // Nuevos logros de ingresos
            [
                'name' => 'Primer ingreso',
                'description' => 'Registra tu primer ingreso.',
                'points' => 5,
                'condition' => 'income:first',
            ],
            [
                'name' => 'Ingresos constantes',
                'description' => 'Registra ingresos durante 7 días distintos.',
                'points' => 15,
                'condition' => 'income:7days',
            ],
            [
                'name' => 'Productividad creciente',
                'description' => 'Alcanza 1000 € registrados en ingresos.',
                'points' => 25,
                'condition' => 'income:1000',
            ],
            [
                'name' => 'Gran ingreso',
                'description' => 'Registra un ingreso único de al menos 500 €.',
                'points' => 40,
                'condition' => 'income:single500',
            ],
            [
                'name' => 'Flujo de ingresos',
                'description' => 'Acumula un total de 5000 € en ingresos registrados.',
                'points' => 80,
                'condition' => 'income:5000',
            ],
            // Nuevos logros de gastos
            [
                'name' => 'Primer gasto',
                'description' => 'Registra tu primer gasto.',
                'points' => 5,
                'condition' => 'outcome:first',
            ],
            [
                'name' => 'Gasto responsable',
                'description' => 'Registra gastos durante 7 días distintos.',
                'points' => 15,
                'condition' => 'outcome:7days',
            ],
            [
                'name' => 'Control de gastos',
                'description' => 'Registra un total de 1000 € en gastos.',
                'points' => 25,
                'condition' => 'outcome:1000',
            ],
            [
                'name' => 'Gasto grande',
                'description' => 'Registra un único gasto de al menos 300 €.',
                'points' => 30,
                'condition' => 'outcome:single300',
            ],
            [
                'name' => 'Registro impecable',
                'description' => 'Alcanza 5000 € en gastos registrados.',
                'points' => 70,
                'condition' => 'outcome:5000',
            ],
            // Nuevos logros de objetivos de ahorro
            [
                'name' => 'Meta alcanzada',
                'description' => 'Completa tu primer objetivo de ahorro.',
                'points' => 10,
                'condition' => 'goal:first',
            ],
            [
                'name' => 'Disciplina financiera',
                'description' => 'Cumple 3 objetivos de ahorro.',
                'points' => 20,
                'condition' => 'goal:3',
            ],
            [
                'name' => 'Enfocado en el futuro',
                'description' => 'Completa un objetivo de al menos 1000 €.',
                'points' => 35,
                'condition' => 'goal:1000',
            ],
            [
                'name' => 'Ahorro consistente',
                'description' => 'Cumple 5 metas de ahorro.',
                'points' => 50,
                'condition' => 'goal:5',
            ],
            [
                'name' => 'Maestro del ahorro',
                'description' => 'Cumple un total de 10 objetivos de ahorro.',
                'points' => 100,
                'condition' => 'goal:10',
            ],
        ];

        foreach ($logros as $logro) {
            Achievement::firstOrCreate(
                ['name' => $logro['name']],
                $logro
            );
        }
    }
}