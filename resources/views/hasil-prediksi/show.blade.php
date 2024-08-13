@extends('layout.master')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!-- Breadcrumb -->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Detail Hasil Prediksi</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Hasil Prediksi</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- End Breadcrumb -->

            <div class="card">
                <div class="card-header bg-primary">
                    <h5 class="card-title text-white">Detail Hasil Prediksi</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nama Barang</th>
                                    <td>{{ $hasilPrediksi->nama_barang }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td>{{ $hasilPrediksi->kategori }}</td>
                                </tr>
                                <tr>
                                    <th>Karat</th>
                                    <td>{{ $hasilPrediksi->karat }}</td>
                                </tr>
                                <tr>
                                    <th>Gram</th>
                                    <td>{{ $hasilPrediksi->gram }}</td>
                                </tr>
                                <tr>
                                    <th>Harga</th>
                                    <td>{{ number_format($hasilPrediksi->harga, 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Stok</th>
                                    <td>{{ $hasilPrediksi->stok }}</td>
                                </tr>
                                <tr>
                                    <th>Terjual</th>
                                    <td>{{ $hasilPrediksi->terjual }}</td>
                                </tr>
                                <tr>
                                    <th>Bulan</th>
                                    <td>{{ \Carbon\Carbon::createFromFormat('m', $hasilPrediksi->bulan)->translatedFormat('F') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tahun</th>
                                    <td>{{ $hasilPrediksi->tahun }}</td>
                                </tr>
                                <tr>
                                    <th>Hasil</th>
                                    <td>
                                        <span
                                            class="badge {{ $hasilPrediksi->hasil == 'Cukup' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $hasilPrediksi->hasil }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>
                                        @if ($hasilPrediksi->hasil == 'Cukup')
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
                                <tr>
                                    <th>Restock</th>
                                    <td>{{ $hasilPrediksi->hasil == 'Cukup' ? 0 : $hasilPrediksi->prediksi_restock }}</td>
                                </tr>
                                <tr>
                                    <th>Estimasi Harga</th>
                                    <td>{{ is_numeric($hasilPrediksi->estimasi_harga) ? number_format($hasilPrediksi->estimasi_harga, 2, ',', '.') : $hasilPrediksi->estimasi_harga }}
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    {{-- <div class="mt-3">
                    <h5>Probabilitas Prior</h5>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Jumlah Cukup</td>
                                <td>{{ $cukup_count }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah Kurang</td>
                                <td>{{ $kurang_count }}</td>
                            </tr>
                            <tr>
                                <td>P(Y=Cukup)</td>
                                <td>{{ number_format($prob_cukup, 4) }}</td>
                                <td>P(Y=Cukup) = {{ $cukup_count }} / {{ $cukup_count + $kurang_count }}</td>
                            </tr>
                            <tr>
                                <td>P(Y=Kurang)</td>
                                <td>{{ number_format($prob_kurang, 4) }}</td>
                                <td>P(Y=Kurang) = {{ $kurang_count }} / {{ $cukup_count + $kurang_count }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <h5>Probabilitas Kondisional</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Fitur</th>
                                <th>Nilai</th>
                                <th>Jumlah Cukup</th>
                                <th>Jumlah Kurang</th>
                                <th>P(Fitur | Y=Cukup)</th>
                                <th>P(Fitur | Y=Kurang)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prob_details['prob_details'] as $feature => $detail)
                                <tr>
                                    <td>{{ ucfirst($feature) }}</td>
                                    <td>{{ $detail['value'] }}</td>
                                    <td>{{ $detail['cukup_count'] }}</td>
                                    <td>{{ $detail['kurang_count'] }}</td>
                                    <td>{{ number_format($detail['prob_cukup'], 4) }}</td>
                                    <td>{{ number_format($detail['prob_kurang'], 4) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <h5>Probabilitas Total</h5>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>P(X | Y=Cukup) * P(Y=Cukup)</td>
                                <td>{{ number_format($prob_details['prob_cukup'], 10) }}</td>
                                <td>P(X | Y=Cukup) * P(Y=Cukup) = {{ implode(' * ', array_map(fn($v) => number_format($v, 4), $prob_details['prob_cukup_details'])) }}</td>
                            </tr>
                            <tr>
                                <td>P(X | Y=Kurang) * P(Y=Kurang)</td>
                                <td>{{ number_format($prob_details['prob_kurang'], 10) }}</td>
                                <td>P(X | Y=Kurang) * P(Y=Kurang) = {{ implode(' * ', array_map(fn($v) => number_format($v, 4), $prob_details['prob_kurang_details'])) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
