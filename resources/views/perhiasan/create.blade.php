@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
  $(document).ready(function() {
    $('.rupiahInput').mask('000.000.000.000.000', { reverse: true });
  });
</script>


@stop
@section('css')

@stop


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
                        </li> <li class="breadcrumb-item active" aria-current="page">Tambah Perhiasan </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="col">
            
            @if(session()->has('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
        @endif
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div><i class="font-22 text-primary"></i>
                        </div>
                        <h5 class="mb-0 text-primary">Form Tambah Perhiasan</h5>
                    </div>
                    <hr>
                    <form class="row g-3" action="{{route('perhiasan.store')}}" method="post">
                          @csrf

                   <!--      <div class="col-12">
                            <label class="form-label">Tgl Transaksi</label>
                            <input type="date" value="{{date('Y-m-d')}}"   class="form-control" name="tgl_transaksi" required >
                        </div> -->
                        <div class="col-12">
                            <label class="form-label">Kode</label>
                            <input type="text" readonly class="form-control" name="kode" value="{{$last_no}}"  >
                        </div>

                        <div class="col-12">
                            <label class="form-label">Jenis Produk</label>
                            <select class="form-control" name="jenis_id" required>
                                <option value="">Pilih Jenis Produk</option>
                                @foreach($jenisproduks as $jenis)
                                    <option value="{{$jenis->id}}">{{$jenis->jenis}} / {{$jenis->kadar}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Nama Perhiasan</label>
                            <input type="text"  class="form-control" name="nama" autofocus >
                        </div>
                        <div class="col-12">
                            <label class="form-label">Berat</label>
                            <input type="text"  class="form-control" name="berat"  >
                        </div>
                        <div class="col-12">
                            <label class="form-label">Harga</label>
                            <input type="text"  class="form-control rupiahInput" name="harga"  >
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