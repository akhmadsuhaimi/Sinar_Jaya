@extends('layout.master')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Jenis Produk</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li> <li class="breadcrumb-item active" aria-current="page">Edit Jenis Produk</li>
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
                        <h5 class="mb-0 text-primary">Form Edit Jenis Produk</h5>
                    </div>
                    <hr>
                    <form class="row g-3" action="{{route('jenisproduk.update', $data->id)}}" method="post">
                          @csrf
                         @method('put')
                        <div class="col-12">
                            <label class="form-label">Nama Jenis</label>
                            <input type="text"   class="form-control" value="{{$data->jenis}}" name="jenis" required autofocus>
                        </div>
                         <div class="col-12">
                            <label class="form-label">Kadar</label>
                            <select required name="kadar" class="form-select">
                                <option value="">Pilih</option>
                                <option value="24"  {{$data->kadar == '24' ? 'selected' : ''}}>24</option>
                                <option value="17" {{$data->kadar == '17' ? 'selected' : ''}}>17</option>
                                <option value="16" {{$data->kadar == '16' ? 'selected' : ''}}>16</option>
                            </select>
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