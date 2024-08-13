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
                </li> <li class="breadcrumb-item active" aria-current="page">Edit Perhiasan</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="col">
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div><i class="font-22 text-primary"></i>
                        </div>
                        <h5 class="mb-0 text-primary">Form Edit Perhiasan</h5>
                    </div>
                    <hr>
                    <form class="row g-3" action="{{route('perhiasan.update', $data->id)}}" method="post">
                          @csrf
                         @method('put')
                          <div class="col-12">
                            <label class="form-label">Kode</label>
                            <input type="text" readonly class="form-control" name="kode" value="{{$data->kode}}"  >
                        </div>

                        <div class="col-12">
                            <label class="form-label">Jenis Produk</label>
                            <select class="form-control" name="jenis_id" required>
                                <option value="">Pilih Jenis Produk</option>
                                @foreach($jenisproduks as $jenis)
                                    <option value="{{$jenis->id}}" {{($data->jenis_id == $jenis->id ? 'selected' : '')}}>{{$jenis->jenis}} / {{$jenis->kadar}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Nama Perhiasan</label>
                            <input type="text"  class="form-control" name="nama" autofocus value="{{$data->nama}}" >
                        </div>
                        <div class="col-12">
                            <label class="form-label">Berat</label>
                            <input type="text"  class="form-control" name="berat"  value="{{$data->berat}}"    >
                        </div>
                        <div class="col-12">
                            <label class="form-label">Harga</label>
                            <input type="text"  class="form-control rupiahInput"   value="{{$data->harga}}"  name="harga"  >
                        </div>


                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-primary px-5">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection