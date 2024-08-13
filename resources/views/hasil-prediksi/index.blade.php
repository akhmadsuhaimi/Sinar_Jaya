@extends('layout.master')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Hasil Prediksi</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Hasil Prediksi</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->
        @if(session()->has('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">    
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 class="card-title text-white">Daftar Hasil Prediksi</h5>
                <div>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#cetakModal">Cetak Laporan</button>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#cetakStokKurangModal">Laporan Stok Kurang</button>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#cetakStokCukupModal">Laporan Stok Cukup</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="example2">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Karat</th>
                                <th>Gram</th>
                                <th>Total Harga</th>
                                <th>Stok</th>
                                <th>Terjual</th>
                                <th>Bulan</th>
                                <th>Tahun</th>
                                <th>Hasil</th>
                                <th>Restock</th>
                                <th>Estimasi Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hasilPrediksi as $prediksi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $prediksi->nama_barang }}</td>
                                    <td>{{ $prediksi->kategori }}</td>
                                    <td>{{ $prediksi->karat }}</td>
                                    <td>{{ $prediksi->gram }}</td>
                                    {{-- <td>{{ number_format($prediksi->harga, 2, ',', '.') }}</td> --}}
                                    <td>{{ number_format($prediksi->harga * $prediksi->stok * $prediksi->gram, 2, ',', '.') }}</td>
                                    <td>{{ $prediksi->stok }}</td>
                                    <td>{{ $prediksi->terjual }}</td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('m', $prediksi->bulan)->translatedFormat('F') }}</td>
                                    <td>{{ $prediksi->tahun }}</td>
                                    <td>
                                        <span class="badge {{ $prediksi->hasil == 'Cukup' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $prediksi->hasil }}
                                        </span>
                                    </td>
                                    <td>{{ $prediksi->hasil == 'Cukup' ? 0 : $prediksi->prediksi_restock }}</td>
                                    <td>{{ is_numeric($prediksi->estimasi_harga) ? number_format($prediksi->estimasi_harga, 2, ',', '.') : $prediksi->estimasi_harga }}</td>
                                    <td>
                                        <a href="{{ route('hasil-prediksi.show', $prediksi->id) }}" class="btn btn-info btn-sm">Lihat</a>
                                        <form action="{{ route('hasil-prediksi.destroy', $prediksi->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cetak Laporan -->
    <div class="modal fade" id="cetakModal" tabindex="-1" aria-labelledby="cetakModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('hasil-prediksi.print') }}" method="GET" target="_blank">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cetakModalLabel">Cetak Laporan Hasil Prediksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bulan_tahun" class="form-label">Bulan dan Tahun:</label>
                            <input type="month" class="form-control" id="bulan_tahun" name="bulan_tahun" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Cetak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Cetak Stok Kurang -->
    <div class="modal fade" id="cetakStokKurangModal" tabindex="-1" aria-labelledby="cetakStokKurangModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('stok.print_kurang') }}" method="GET" target="_blank">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cetakStokKurangModalLabel">Cetak Laporan Stok Kurang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bulan_tahun_kurang" class="form-label">Bulan dan Tahun:</label>
                            <input type="month" class="form-control" id="bulan_tahun_kurang" name="bulan_tahun" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Cetak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Cetak Stok Kurang -->
    <div class="modal fade" id="cetakStokCukupModal" tabindex="-1" aria-labelledby="cetakStokCukupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('stok.print_cukup') }}" method="GET" target="_blank">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cetakStokCukupModalLabel">Cetak Laporan Stok Cukup</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bulan_tahun_cukuo" class="form-label">Bulan dan Tahun:</label>
                            <input type="month" class="form-control" id="bulan_tahun_cukuo" name="bulan_tahun" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Cetak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
