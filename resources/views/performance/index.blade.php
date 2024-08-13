@extends('layout.master')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Performance</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Performance</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="row">
                <div class="col-4">
                    <div class="card text-center">
                        <div class="card-body bg-success text-white">
                            <h5 class="card-title">Akurasi</h5>
                            <p class="card-text">{{ number_format($displayAccuracy * 100, 2) }}%</p>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card text-center">
                        <div class="card-body bg-info text-white">
                            <h5 class="card-title">Recall</h5>
                            <p class="card-text">{{ number_format($recall * 100, 2) }}%</p>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card text-center">
                        <div class="card-body bg-warning text-white">
                            <h5 class="card-title">Precision</h5>
                            <p class="card-text">{{ number_format($precision * 100, 2) }}%</p>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="card-title text-center">Performance Chart</h5>
                    <canvas id="performanceChart"></canvas>
                </div>
            </div>

            {{-- <div class="row mt-4">
                <div class="col-12">
                    <h5 class="card-title text-center">Total Data Chart</h5>
                    <canvas id="totalDataChart"></canvas>
                </div>
            </div> --}}

        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            var ctx = document.getElementById('performanceChart').getContext('2d');
            var performanceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Akurasi', 'Recall', 'Precision'],
                    datasets: [{
                        label: 'Performance Metrics',
                        data: [{{ $displayAccuracy * 100 }}, {{ $recall * 100 }},
                            {{ $precision * 100 }}
                        ],
                        backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)'
                        ],
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var ctx2 = document.getElementById('totalDataChart').getContext('2d');
            var totalDataChart = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: ['Total Data Latih', 'Total Data Uji', 'Total Hasil Prediksi'],
                    datasets: [{
                        label: 'Total Data',
                        data: [{{ $total_data_latih }}, {{ $total_data_uji }},
                            {{ $total_hasil_prediksi }}
                        ],
                        backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
