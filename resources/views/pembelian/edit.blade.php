@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    $(document).ready(function() {
      $('.rupiahInput').mask('000.000.000.000.000', { reverse: true });
  
      // Fungsi untuk menangani perubahan pada dropdown perhiasan_id
      $('select[name="perhiasan_id"]').change(function() {
        var selectedPerhiasan = $(this).find(':selected');
        var harga = selectedPerhiasan.data('harga');
        var stok = selectedPerhiasan.data('stok');
        var berat = selectedPerhiasan.data('berat');
  
        // Set nilai stok di input
        $('#stok').val(stok);
        $('#berat').val(berat);
  
        // Reset nilai qty, total harga, dan harga beli
        $('input[name="qty"]').val('');
        $('#total_harga').val('');
        $('#harga_beli').val('');
      });
  
      // Fungsi untuk menangani perubahan pada input harga_beli
      $('input[name="harga_beli"]').change(function() {
        // Hitung total harga berdasarkan qty * harga
        var harga = parseInt($(this).val().replace(/\D/g,'')) || 0; // Menggunakan 0 jika harga_beli tidak diisi
        var qty = parseInt($('input[name="qty"]').val()) || 0; // Menggunakan 0 jika qty tidak diisi
        var berat = parseFloat($('input[name="berat"]').val()) || 0;
        var totalHarga = (berat * harga) * qty;
        $('#total_harga').val(totalHarga.toLocaleString('id-ID'));
      });
  
      $('input[name="qty"]').change(function() {
        // Hitung total harga berdasarkan qty * harga
        var harga = parseInt($('input[name="harga_beli"]').val().replace(/\D/g,'')) || 0; // Menggunakan 0 jika harga_beli tidak diisi
        var qty = parseInt($(this).val()) || 0; // Menggunakan 0 jika qty tidak diisi
        var berat = parseFloat($('input[name="berat"]').val()) || 0;
        var totalHarga = (berat * harga) * qty;
        $('#total_harga').val(totalHarga.toLocaleString('id-ID'));
      });
    });
  </script>
@stop

@extends('layout.master')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Pembelian</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li> <li class="breadcrumb-item active" aria-current="page">Edit Pembelian</li>
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
                        <h5 class="mb-0 text-primary">Form Edit Pembelian</h5>
                    </div>
                    <hr>
                    <form class="row g-3" action="{{route('pembelian.update', $data->id)}}" method="post">
                          @csrf
                         @method('put')
                          <div class="col-12">
                            <label class="form-label">No Faktur</label>
                            <input type="text" readonly class="form-control" name="no_faktur" value="{{$data->no_faktur}}" >
                        </div>
                        <div class="col-12">
                            <label class="form-label">Tgl Pembelian</label>
                            <input type="date" value="{{$data->tgl_pembelian}}"   class="form-control" name="tgl_pembelian" required >
                        </div> 

                        <div class="col-12">
                            <label class="form-label">Perhiasan</label>
                            <select class="form-control" name="perhiasan_id" disabled>
                                <option value="">Pilih Perhiasan</option>
                                @foreach($perhiasans as $perhiasan)
                                    <option value="{{$perhiasan->id}}" data-harga="{{$perhiasan->harga}}" data-stok="{{$perhiasan->stok}}" data-berat="{{$perhiasan->berat}}" {{($data->perhiasan_id == $perhiasan->id ? 'selected' : '')}}>{{$perhiasan->nama}} / {{$perhiasan->berat}} gr / Stok : {{$perhiasan->stok}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Stok</label>
                            <input type="text"  class="form-control" name="stok" id="stok" value="{{$data->perhiasan->stok}}" readonly >
                            <input type="hidden" name="berat" id="berat" value="{{$data->perhiasan->berat}}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Harga Beli</label>
                            <input type="text"  class="form-control rupiahInput" name="harga_beli" value="{{$data->harga_beli}}" id="harga_beli"  >
                        </div>
                        <div class="col-12">
                            <label class="form-label">Qty</label>
                            <input type="text"  class="form-control" name="qty" value="{{$data->qty}}" disabled >
                        </div>
                        <div class="col-12">
                            <label class="form-label">Total Pembelian</label>
                            <input type="text" readonly class="form-control" name="total_harga" id="total_harga" value="{{ number_format((str_replace('.','', $data->harga_beli) * $data->perhiasan->berat) * $data->qty, 0, ',', '.') }}" >
                        </div>
                        <p class="text-muted text-danger">Perhiasan & Qty tidak bisa diubah karena sudah stok sudah terinput.</p>


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