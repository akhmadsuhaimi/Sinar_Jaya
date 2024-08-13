@extends('layout.master')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!-- Breadcrumb -->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Prediksi Restock</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Prediksi Restock</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- End Breadcrumb -->

            <!-- Error Message -->
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- End Error Message -->

            <div class="col">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h5 class="card-title text-white">Prediksi Restock Berdasarkan Periode</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('penjualan.filterPrediksi') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="bulan" class="form-label">Bulan:</label>
                                    <select class="form-select" id="bulan" name="bulan" required>
                                        @php
                                            $bulanIndonesia = [
                                                '01' => 'Januari',
                                                '02' => 'Februari',
                                                '03' => 'Maret',
                                                '04' => 'April',
                                                '05' => 'Mei',
                                                '06' => 'Juni',
                                                '07' => 'Juli',
                                                '08' => 'Agustus',
                                                '09' => 'September',
                                                '10' => 'Oktober',
                                                '11' => 'November',
                                                '12' => 'Desember',
                                            ];
                                        @endphp
                                        @foreach ($bulanIndonesia as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ (isset($bulan_dipilih) && str_pad($bulan_dipilih, 2, '0', STR_PAD_LEFT) == $key) || (isset($bulan) && str_pad($bulan, 2, '0', STR_PAD_LEFT) == $key) ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tahun" class="form-label">Tahun:</label>
                                    <select class="form-select" id="tahun" name="tahun" required>
                                        @foreach (range(2023, 2023 + 5) as $year)
                                            <option value="{{ $year }}"
                                                {{ (isset($tahun_dipilih) && $tahun_dipilih == $year) || (isset($tahun) && $tahun == $year) ? 'selected' : '' }}>
                                                {{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-chart-line"></i>
                                        Prediksi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @isset($results)
                    <div class="card mt-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title text-white">Hasil Prediksi Algoritma Naive Bayes Pada Bulan
                                {{ $bulanIndonesia[str_pad($bulan_dipilih ?? $bulan, 2, '0', STR_PAD_LEFT)] }} Tahun
                                {{ $tahun_dipilih ?? $tahun }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Kategori</th>
                                            <th>Karat</th>
                                            <th>Gram</th>
                                            <th>Jumlah Harga</th>
                                            <th>Stok</th>
                                            <th>Terjual</th>
                                            {{-- <th>Bulan</th>
                                            <th>Tahun</th> --}}
                                            <th>Hasil</th>
                                            <th>Restock</th>
                                            <th>Estimasi Harga</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results as $result)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $result['nama_barang'] }}</td>
                                                <td>{{ $result['kategori'] }}</td>
                                                <td>{{ $result['karat'] }}</td>
                                                <td>{{ $result['gram'] }}</td>
                                                {{-- <td>{{ number_format($result['harga'], 2, ',', '.') }}</td> --}}
                                                <td>{{ number_format($result['harga'] * $result['stok'] * $result['gram'], 2, ',', '.') }}</td>
                                                <td>{{ $result['stok'] }}</td>
                                                <td>{{ $result['terjual'] }}</td>
                                                {{-- <td>{{ $bulanIndonesia[str_pad($result['bulan'], 2, '0', STR_PAD_LEFT)] }}</td>
                                                <td>{{ $result['tahun'] }}</td> --}}
                                                <td>
                                                    <span
                                                        class="badge {{ $result['hasil'] == 'Cukup' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $result['hasil'] }}
                                                    </span>
                                                </td>
                                                <td>{{ $result['hasil'] == 'Cukup' ? 0 : $result['prediksi_restock'] }}
                                                </td>
                                                <td>{{ is_numeric($result['estimasi_harga']) ? number_format($result['estimasi_harga'], 2, ',', '.') : $result['estimasi_harga'] }}
                                                </td>
                                                <td>
                                                    @if ($result['hasil'] == 'Cukup')
                                                        Stok perhiasan ini cukup untuk bulan ini. Pertimbangkan untuk
                                                        mempertahankan jumlah stok atau menyesuaikan sedikit berdasarkan
                                                        penjualan selanjutnya.
                                                    @else
                                                        Stok perhiasan ini kurang dan perlu ditambah. Permintaan tinggi
                                                        menunjukkan bahwa produk ini populer. Pertimbangkan untuk menambah stok
                                                        untuk bulan berikutnya.
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </div>
@endsection
