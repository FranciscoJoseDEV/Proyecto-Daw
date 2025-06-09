@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen bg-gray-50">
        <main class="flex-1 p-6">
            {{-- Alertas --}}
            @if (session('warning'))
                <div class="mb-4 bg-cssecondary border-l-4 p-4 rounded">
                    <span class="block">{{ session('warning') }}</span>
                </div>
            @endif

            {{-- Balance y Racha en dos columnas estilo estadísticas --}}
            <div class="container-fluid py-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- Columna Balance -->
                            <div class="col-md-6 mb-4 d-flex flex-column align-items-center justify-content-center">
                                <span
                                    class="material-icons text-green-400 text-5xl mb-2 animate-bounce">account_balance_wallet</span>
                                <h2 class="text-xl font-semibold text-gray-700 mb-1">Balance Actual</h2>
                                <p id="balance" class="text-4xl font-bold text-green-600 mt-2">
                                    {{ number_format($user->savings, 2, ',', '.') }} €
                                </p>
                            </div>
                            <!-- Columna Racha -->
                            <div class="col-md-6 mb-4 d-flex flex-column align-items-center justify-content-center">
                                <span id="streak-icon"
                                    class="material-icons text-yellow-400 text-5xl mb-2 animate-pulse">local_fire_department</span>
                                <h2 class="text-xl font-semibold text-gray-700 mb-1">Racha de Días</h2>
                                <p id="streak" class="text-4xl font-bold text-yellow-600 mt-2">
                                    {{ Auth::user()->streak_count ?? 0 }} <span
                                        class="text-base font-normal text-gray-400">días</span>
                                </p>
                                @if (Auth::user()->streak_count > 0)
                                    <p class="mt-2 text-sm text-yellow-700">¡Sigue así para mantener tu racha!</p>
                                @else
                                    <p class="mt-2 text-sm text-gray-400">¡Comienza tu racha hoy!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- MOVIMIENTOS RECIENTES GRÁFICO --}}
            <div class="container-fluid py-4">
                <div class="card shadow-sm">
                    <div class="card-body" style="height: 550px;">
                        <h3 class="text-md font-semibold flex items-center mb-4">
                            <span class="material-icons">bar_chart</span>
                            Ingresos vs Gastos
                        </h3>
                        <canvas id="incomeOutcomeChart" height="400" style="width:100%;display:block;"></canvas>
                    </div>
                </div>
            </div>
            <button id="exportPdfBtn" class="btn btn-outline-primary mb-3">
                <span class="material-icons align-middle">picture_as_pdf</span>
                Exportar gráfico a PDF
            </button>


        </main>
    </div>
@endsection
@push('styles')
    <style>
        #incomeOutcomeChart {
            width: 100% !important;
            display: block;
            max-width: 100%;
            height: 450px !important;
        }
    </style>
@endpush
@push('scripts')
    {{-- SCRIPTS Y ANIMACIONES --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        // Animación balance y racha
        document.addEventListener('DOMContentLoaded', function() {
            // Balance
            const balanceElement = document.getElementById('balance');
            const targetBalance = {{ $user->savings }};
            let currentBalance = 0;
            const increment = Math.ceil(targetBalance / 100);

            const interval = setInterval(() => {
                currentBalance += increment;
                if (currentBalance >= targetBalance) {
                    currentBalance = targetBalance;
                    clearInterval(interval);
                }
                balanceElement.textContent = `${currentBalance.toLocaleString()} €`;
            }, 20);

            // Racha de días con icono dinámico
            const streakElement = document.getElementById('streak');
            const streakIcon = document.getElementById('streak-icon');
            const targetStreak = {{ Auth::user()->streak_count ?? 0 }};
            let currentStreak = 0;
            const streakIncrement = targetStreak > 0 ? Math.ceil(targetStreak / 50) : 1;

            // Tamaño base y máximo del icono
            const baseSize = 40; // px
            const maxSize = 100; // px

            // Factor de crecimiento más lento por día de racha
            // Puedes ajustar el divisor (por ejemplo, 2, 3, 4...) para que el crecimiento sea más lento
            const growthDivisor = 3;

            let currentIconSize = baseSize;

            const streakInterval = setInterval(() => {
                currentStreak += streakIncrement;
                if (currentStreak >= targetStreak) {
                    currentStreak = targetStreak;
                }
                streakElement.innerHTML =
                    `${currentStreak} <span class="text-base font-normal text-gray-400">días</span>`;

                // Cambia el color del icono a dorado si la racha es 100 o más
                if (currentStreak >= 100) {
                    streakIcon.classList.remove('text-yellow-400');
                    streakIcon.classList.add('text-yellow-600');
                    streakIcon.style.color = '#FFD700'; // dorado
                } else {
                    streakIcon.classList.remove('text-yellow-600');
                    streakIcon.classList.add('text-yellow-400');
                    streakIcon.style.color = '';
                }

                // El tamaño crece más lento por cada día de racha
                let targetIconSize = baseSize;
                if (targetStreak > 0) {
                    // El crecimiento es proporcional pero más lento
                    targetIconSize = baseSize + Math.min(((currentStreak / (targetStreak * growthDivisor)) *
                        (maxSize - baseSize)), maxSize - baseSize);
                }

                currentIconSize += (targetIconSize - currentIconSize) * 0.1;
                streakIcon.style.fontSize = currentIconSize + 'px';

                if (currentStreak >= targetStreak && Math.abs(currentIconSize - targetIconSize) < 1) {
                    streakIcon.style.fontSize = targetIconSize + 'px';
                    clearInterval(streakInterval);
                }
            }, 20);

            // Gráfico de Balance Acumulado
            const ctx = document.getElementById('incomeOutcomeChart').getContext('2d');
            const balanceChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                            label: 'Balance',
                            data: {!! json_encode($balanceData) !!},
                            backgroundColor: 'rgba(37, 99, 235, 0.2)',
                            borderColor: 'rgba(37, 99, 235, 1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3,
                            pointRadius: 3
                        },
                        {
                            label: 'Ingresos Recurrentes',
                            data: {!! json_encode($recurrentIncomesData) !!},
                            borderColor: 'rgba(34, 197, 94, 1)',
                            backgroundColor: 'rgba(34, 197, 94, 0.2)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.3,
                            pointRadius: 2
                        },
                        {
                            label: 'Ingresos No Recurrentes',
                            data: {!! json_encode($nonRecurrentIncomesData) !!},
                            borderColor: 'rgba(16, 185, 129, 1)',
                            backgroundColor: 'rgba(16, 185, 129, 0.2)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.3,
                            pointRadius: 2
                        },
                        {
                            label: 'Gastos Recurrentes',
                            data: {!! json_encode($recurrentOutcomesData) !!},
                            borderColor: 'rgba(239, 68, 68, 1)',
                            backgroundColor: 'rgba(239, 68, 68, 0.2)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.3,
                            pointRadius: 2
                        },
                        {
                            label: 'Gastos No Recurrentes',
                            data: {!! json_encode($nonRecurrentOutcomesData) !!},
                            borderColor: 'rgba(251, 113, 133, 1)',
                            backgroundColor: 'rgba(251, 113, 133, 0.2)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.3,
                            pointRadius: 2
                        }
                    ]

                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') +
                                        ' €';
                                }
                            }
                        }
                    }
                }
            });
        });

        document.getElementById('exportPdfBtn').addEventListener('click', function() {
            const chartContainer = document.getElementById('incomeOutcomeChart');
            html2canvas(chartContainer).then(function(canvas) {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new window.jspdf.jsPDF({
                    orientation: 'landscape',
                    unit: 'pt',
                    format: [canvas.width, canvas.height]
                });
                pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);
                pdf.save('grafico-ingresos-gastos.pdf');
            });
        });

        // --- Conversor de divisas usando ExchangeRate-API ---
        const exchangeRateApiKey = "{{ config('services.exchangerate.key') }}";
        const balanceElement = document.getElementById('balance');
        const balanceValue = {{ $user->savings }};
        const currencySelect = document.createElement('select');
        currencySelect.className = 'form-select mb-2';
        currencySelect.style.width = 'auto';

        const currencySymbols = {
            'USD': '$',
            'EUR': '€',
            'GBP': '£',
            'JPY': '¥',
            'MXN': '$'
        };

        const currencies = ['USD', 'EUR', 'GBP', 'JPY', 'MXN'];
        currencies.forEach(cur => {
            const opt = document.createElement('option');
            opt.value = cur;
            opt.textContent = cur;
            currencySelect.appendChild(opt);
        });

        balanceElement.parentNode.insertBefore(currencySelect, balanceElement.nextSibling);

        // Función para actualizar el balance convertido
        async function updateConvertedBalance() {
            const selectedCurrency = currencySelect.value;
            const symbol = currencySymbols[selectedCurrency] || selectedCurrency;
            if (selectedCurrency === 'EUR') {
                balanceElement.textContent = `${balanceValue.toLocaleString()} ${symbol}`;
                return;
            }
            // Cambia 'YOUR_API_KEY' por tu clave real
            const apiKey = typeof exchangeRateApiKey !== 'undefined' ? exchangeRateApiKey : '';
            const url = `https://v6.exchangerate-api.com/v6/${apiKey}/latest/EUR`;
            try {
                const res = await fetch(url);
                const data = await res.json();
                const rate = data.conversion_rates[selectedCurrency];
                if (rate) {
                    const converted = balanceValue * rate;
                    balanceElement.textContent =
                        `${converted.toLocaleString(undefined, {maximumFractionDigits: 2})} ${symbol}`;
                } else {
                    balanceElement.textContent = 'Error de moneda';
                }
            } catch (e) {
                balanceElement.textContent = 'Error de API';
            }
        }

        // Evento para cambiar la moneda
        currencySelect.addEventListener('change', updateConvertedBalance);

        // Por defecto muestra en EUR
        currencySelect.value = 'EUR';
        updateConvertedBalance();
    </script>
@endpush
