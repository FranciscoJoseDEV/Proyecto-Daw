@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="mb-4 text-center">Estadísticas Semanales</h1>
            <div class="row">
                <!-- Columna de datos -->
                <div class="col-md-6 mb-4">
                    <div class="mb-3">
                        <span class="fw-bold text-secondary">Saldo inicial:</span>
                        <span>{{ number_format($statistics->general_balance - $statistics->income_total + $statistics->outcome_total, 2, ',', '.') }} €</span>
                    </div>
                    <div class="mb-3">
                        <span class="fw-bold text-primary">Ingresos:</span>
                        <span>{{ number_format($statistics->income_total, 2, ',', '.') }} €</span>
                    </div>
                    <div class="mb-3">
                        <span class="fw-bold text-danger">Gastos:</span>
                        <span>{{ number_format($statistics->outcome_total, 2, ',', '.') }} €</span>
                    </div>
                    @if ($statistics->income_total > $statistics->outcome_total)
                        <div class="alert alert-success py-2">
                            <i class="bi bi-emoji-smile"></i> ¡Has ganado más de lo que has gastado esta semana!
                        </div>
                    @elseif($statistics->income_total < $statistics->outcome_total)
                        <div class="alert alert-warning py-2">
                            <i class="bi bi-exclamation-triangle"></i> Has gastado más de lo que has ganado esta semana.
                        </div>
                    @else
                        <div class="alert alert-info py-2">
                            <i class="bi bi-balance-scale"></i> Has gastado y ganado la misma cantidad esta semana.
                        </div>
                    @endif
                    <div class="mb-3 mt-4">
                        <span class="fw-bold text-success">Saldo actual:</span>
                        <span>{{ number_format($statistics->general_balance, 2, ',', '.') }} €</span>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <span class="fw-bold">Día más derrochador:</span>
                        <span class="text-capitalize">{{ \Carbon\Carbon::parse($statistics->most_spending_day)->locale('es')->isoFormat('dddd') }}</span>
                        <br>
                        <span class="fw-bold text-danger">Gasto:</span>
                        <span>{{ number_format($statistics->most_spending_day_total, 2, ',', '.') }} €</span>
                    </div>
                </div>
                <!-- Columna de gráfico -->
                <div class="col-md-6 d-flex flex-column align-items-center">
                    <h5 class="mb-3">Distribución de gastos por categoría</h5>
                    <canvas id="outcomeCategoryChart" style="max-width:250px;max-height:250px;"></canvas>
                    <ul id="category-legend" class="list-unstyled mt-3"></ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const data = @json(json_decode($statistics->outcome_category, true));
        const labels = Object.keys(data);
        const values = Object.values(data);

        const colors = [
            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#5a5c69', '#fd7e14',
            '#20c997', '#6f42c1'
        ];

        const ctx = document.getElementById('outcomeCategoryChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors,
                }]
            },
            options: {
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed || 0;
                                return `${label}: ${value}%`;
                            }
                        }
                    }
                }
            }
        });

        // Leyenda personalizada
        const legend = document.getElementById('category-legend');
        labels.forEach((label, i) => {
            const color = colors[i % colors.length];
            const value = values[i];
            const li = document.createElement('li');
            li.innerHTML = `<span style="display:inline-block;width:16px;height:16px;background:${color};margin-right:8px;border-radius:3px;"></span>
            <strong>${label}</strong>: ${value}%`;
            legend.appendChild(li);
        });
    });
</script>
@endsection
