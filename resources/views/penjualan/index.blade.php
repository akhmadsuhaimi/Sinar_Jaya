@extends('layout.master')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Penjualan</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Data Penjualan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="col">
            <div class="card">
                <div class="card-header">
                    @if (auth()->user()->level == 'admin')
                    <a href="{{route('penjualan.create')}}" class="btn btn-success"> &nbsp; Tambah Penjualan</a>
                    @endif
                    <a href="{{ route('penjualan.laporan') }}" class="btn btn-primary">Laporan Penjualan</a>
                    {{-- <a href="{{ route('penjualan.prediksi') }}" class="btn btn-primary">Prediksi Restock</a> --}}
                </div>
                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-info">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0" id="example2">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">No Faktur</th>
                                    <th scope="col">Tgl Jual</th>
                                    <th scope="col">Jenis</th>
                                    <th scope="col">Kadar</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Harga Beli</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no=1; @endphp
                                @foreach($datas as $data)
                                <tr>
                                    <th scope="row">{{$no;}}</th>
                                    <td>{{$data->no_faktur}}</td>
                                    <td>{{$data->tgl_penjualan}}</td>
                                    <td>
                                    @if(isset($data->perhiasan->jenisproduk->jenis))
                                        {{$data->perhiasan->jenisproduk->jenis}}
                                    @else
                                        -
                                    @endif
                                    </td>
                                    <td>
                                    @if(isset($data->perhiasan->jenisproduk->kadar))
                                        {{$data->perhiasan->jenisproduk->kadar}}
                                    @else
                                        -
                                    @endif
                                    </td>
                                    <td>
                                    @if(isset($data->perhiasan->nama))
                                        {{$data->perhiasan->nama}}
                                    @else
                                        -
                                    @endif
                                    </td>
                                    <td>
                                    @if(isset($data->perhiasan->berat))
                                        {{$data->perhiasan->berat}}
                                    @else
                                        -
                                    @endif
                                    </td>
                                    <td>{{$data->harga_jual}}</td>
                                    <td>{{$data->qty}}</td>
                                    <td>Rp {{number_format(str_replace(".", "", $data->harga_jual) * $data->perhiasan->berat * $data->qty, 0, ',', '.')}}</td>
                                    <td>
                                        <div class="btn-group">
                                             
                                                 <a href="{{route('penjualan.edit', $data->id)}}" class="btn btn-edit btn-info btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                &nbsp;

                                                 <form action="{{route('penjualan.destroy', $data->id)}}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm "
                                                      type="submit" onclick="return confirm('anda yakin ingin menghapus data ini?')"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                         
                                               
                                            </div>
                                    </td>
                                </tr>
                                @php $no++ @endphp
                                @endforeach

                            </tbody>
                        </table></div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
