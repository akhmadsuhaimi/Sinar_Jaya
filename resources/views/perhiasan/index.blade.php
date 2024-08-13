@extends('layout.master')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Perhiasan</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Data Perhiasan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="col">
            <div class="card">
                <div class="card-header">
                            
                    <a href="{{route('perhiasan.create')}}" class="btn btn-success"> &nbsp;<i class="fa fa-plus"></i></a>
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
                                            <th scope="col">Kode</th>
                                            <th scope="col">Jenis</th>
                                            <th scope="col">Kadar</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Berat</th>
                                            <th scope="col">Stok</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=1; @endphp
                                        @foreach($datas as $data)
                                        <tr>
                                            <th scope="row">{{$no;}}</th>
                                            <td>{{$data->kode}}</td>
                                            <td>
                                            @if(isset($data->jenisproduk->jenis))
                                                {{$data->jenisproduk->jenis}}
                                            @else
                                                -
                                            @endif
                                            </td>
                                            <td>
                                            @if(isset($data->jenisproduk->kadar))
                                                {{$data->jenisproduk->kadar}}
                                            @else
                                                -
                                            @endif</td>
                                            <td>{{$data->nama}}</td>
                                            <td>{{$data->berat}}</td>
                                            <td>{{$data->stok}}</td>
                                            
                                            <td>
                                                <div class="btn-group">
                                                     
                                                      <a href="{{route('perhiasan.edit', $data->id)}}" class="btn btn-edit btn-info btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        &nbsp;

                                                         <form action="{{route('perhiasan.destroy', $data->id)}}" method="POST">
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