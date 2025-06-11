@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="mb-4 text-center display-4">Estadísticas Semanales</h1>
            <div class="row g-4">
                <!-- Columna de datos -->
                <div class="col-md-6">
                    <div class="d-flex flex-column gap-3">
                        <div class="card border-secondary shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <i class="bi bi-wallet2 fs-3 text-secondary me-3"></i>
                                <div>
                                    <div class="fw-bold text-secondary">Saldo inicial</div>
                                    <div class="fs-5">{{ number_format($statistics->general_balance - $statistics->income_total + $statistics->outcome_total, 2, ',', '.') }} €</div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-primary shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <i class="bi bi-arrow-down-circle fs-3 text-primary me-3"></i>
                                <div>
                                    <div class="fw-bold text-primary">Ingresos</div>
                                    <div class="fs-5">{{ number_format($statistics->income_total, 2, ',', '.') }} €</div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-danger shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <i class="bi bi-arrow-up-circle fs-3 text-danger me-3"></i>
                                <div>
                                    <div class="fw-bold text-danger">Gastos</div>
                                    <div class="fs-5">{{ number_format($statistics->outcome_total, 2, ',', '.') }} €</div>
                                </div>
                            </div>
                        </div>
                        @if ($statistics->income_total > $statistics->outcome_total)
                            <div class="alert alert-success py-2 d-flex align-items-center">
                                <i class="bi bi-emoji-smile fs-4 me-2"></i>
                                <span>¡Has ganado más de lo que has gastado esta semana!</span>
                            </div>
                        @elseif($statistics->income_total < $statistics->outcome_total)
                            <div class="alert alert-warning py-2 d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle fs-4 me-2"></i>
                                <span>Has gastado más de lo que has ganado esta semana.</span>
                            </div>
                        @else
                            <div class="alert alert-info py-2 d-flex align-items-center">
                                <i class="bi bi-balance-scale fs-4 me-2"></i>
                                <span>Has gastado y ganado la misma cantidad esta semana.</span>
                            </div>
                        @endif
                        <div class="card border-success shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <i class="bi bi-cash-coin fs-3 text-success me-3"></i>
                                <div>
                                    <div class="fw-bold text-success">Saldo actual</div>
                                    <div class="fs-5">{{ number_format($statistics->general_balance, 2, ',', '.') }} €</div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-warning shadow-sm">
                            <div class="card-body">
                                <div class="fw-bold mb-1"><i class="bi bi-calendar2-week text-warning me-2"></i>Día más derrochador</div>
                                <div class="mb-1 text-capitalize">
                                    {{ \Carbon\Carbon::parse($statistics->most_spending_day)->locale('es')->isoFormat('dddd') }}
                                </div>
                                <span class="fw-bold text-danger">Gasto:</span>
                                <span>{{ number_format($statistics->most_spending_day_total, 2, ',', '.') }} €</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Columna de gráfico -->
                <div class="col-md-6 d-flex flex-column align-items-center">
                    <div class="card w-100 shadow-sm">
                        <div class="card-body d-flex flex-column align-items-center">
                            <h5 class="mb-3">Distribución de gastos por categoría</h5>
                            <canvas id="outcomeCategoryChart" style="max-width:250px;max-height:250px;"></canvas>
                            <ul id="category-legend" class="list-unstyled mt-3"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
@endpush
