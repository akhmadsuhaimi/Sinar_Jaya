@extends('layout.master')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Datasets</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data Datasets</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col">
                <div class="card">
                    {{-- <div class="card-header">
                        <a href="{{ route('datasets.importForm') }}" class="btn btn-success"> &nbsp;<i
                                class="fa fa-plus"></i> Import Data</a>
                    </div> --}}
                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-info">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0" id="example2">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Karat</th>
                                        <th scope="col">Gram</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Stok</th>
                                        <th scope="col">Hasil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($datasets as $dataset)
                                        <tr>
                                            <th scope="row">{{ $no }}</th>
                                            <td>{{ $dataset->nama_barang }}</td>
                                            <td>{{ $dataset->kategori }}</td>
                                            <td>{{ $dataset->karat }}</td>
                                            <td>{{ $dataset->gram }}</td>
                                            <td>{{ $dataset->harga }}</td>
                                            <td>{{ $dataset->stok }}</td>
                                            <td>{{ $dataset->hasil }}</td>
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
