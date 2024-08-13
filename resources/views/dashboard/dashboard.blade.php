@extends('layout.master')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Dashboard</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Selamat datang dihalaman <span class="badge rounded-pill btn-info">{{ Auth::user()->level == 'admin' ? 'Admin' : 'Pimpinan' }}</span></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <!-- Filter Tahun -->
        <div class="row mb-4">
            <div class="col-md-4">
                <form action="{{ url('dashboard') }}" method="GET">
                    <div class="input-group">
                        <select class="form-select" name="tahun" onchange="this.form.submit()">
                            @foreach(range(date('Y'), date('Y') - 10) as $year)
                                <option value="{{ $year }}" {{ $tahunDipilih == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary" type="submit">Filter</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Filter Tahun -->

        <!-- Dashboard Summary -->
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body bg-primary text-white">
                        <h5 class="card-title">Penjualan Tahun Ini</h5>
                        <p class="card-text">{{ $penjualanTahunIni }} Perhiasan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body bg-success text-white">
                        <h5 class="card-title">Pembelian Tahun Ini</h5>
                        <p class="card-text">{{ $pembelianTahunIni }} Perhiasan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body bg-warning text-white">
                        <h5 class="card-title">Total Jenis Perhiasan</h5>
                        <p class="card-text">{{ $totalPerhiasan }} Jenis</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Penjualan Chart -->
        <div class="row mt-4">
            <div class="col-12">
                <canvas id="penjualanChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        var ctx = document.getElementById('penjualanChart').getContext('2d');
        var penjualanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($bulanPenjualan),
                datasets: [{
                    label: 'Penjualan per Bulan',
                    data: @json($jumlahPenjualanPerBulan),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
