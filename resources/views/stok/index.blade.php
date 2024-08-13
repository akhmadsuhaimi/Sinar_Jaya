@extends('layout.master')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Stok</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data Stok
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-info">
                                {{ session('message') }}
                            </div>
                        @endif
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('stok.print_menipis') }}" target="_blank" class="btn btn-warning me-2">Cetak
                                Stok Menipis</a>
                            <a href="{{ route('stok.print_terlaris') }}" target="_blank" class="btn btn-success">Cetak
                                Penjualan Terlaris</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0" id="example2">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kode</th>
                                        <th scope="col">Jenis</th>
                                        <th scope="col">Kadar</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Pembelian</th>
                                        <th scope="col">Penjualan</th>
                                        <th scope="col">Sisa Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no=1; @endphp
                                    @foreach ($datas as $data)
                                        <tr>
                                            <th scope="row">{{ $no }}</th>
                                            <td>{{ $data->kode }}</td>
                                            <td>
                                                @if (isset($data->jenisproduk->jenis))
                                                    {{ $data->jenisproduk->jenis }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($data->jenisproduk->kadar))
                                                    {{ $data->jenisproduk->kadar }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $data->nama }}</td>
                                            <td>{{ getTotalQtyPembelian($data->id) }}</td>
                                            <td>{{ getTotalQtyPenjualan($data->id) }}</td>
                                            <td>{{ $data->stok }}</td>
                                        </tr>
                                        @php $no++ @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
