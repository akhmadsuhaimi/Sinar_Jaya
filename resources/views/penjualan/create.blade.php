@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.rupiahInput').mask('000.000.000.000.000', {
                reverse: true
            });

            // Fungsi untuk menangani perubahan pada dropdown perhiasan_id
            $('select[name="perhiasan_id"]').change(function() {
                var selectedPerhiasan = $(this).find(':selected');
                var harga = selectedPerhiasan.data('harga');
                var stok = selectedPerhiasan.data('stok');
                var berat = selectedPerhiasan.data('berat');

                // Set nilai stok dan harga di input
                $('#stok').val(stok);
                $('#berat').val(berat);
                // $('#harga_jual').val(harga);

                // Reset nilai qty dan total harga
                $('input[name="qty"]').val('');
                $('#total_harga').val('');

                // Validasi qty melebihi stok
                $('input[name="qty"]').change(); // Panggil fungsi change untuk melakukan validasi
            });

            // Fungsi untuk menangani perubahan pada input harga_jual
            $('input[name="harga_jual"]').change(function() {
                // Hitung total harga berdasarkan qty * harga jual
                var hargaJual = parseInt($(this).val().replace(/\D/g, '')) ||
                    0; // Menggunakan 0 jika harga_jual tidak diisi
                var qty = parseInt($('input[name="qty"]').val()) || 0; // Menggunakan 0 jika qty tidak diisi
                var berat = parseFloat($('input[name="berat"]').val()) ||
                0; // Menggunakan 0 jika qty tidak diisi

                var totalHarga = (berat * hargaJual) * qty;
                $('#total_harga').val(totalHarga.toLocaleString('id-ID'));

                // Validasi qty melebihi stok
                var stok = parseInt($('#stok').val());
                var qty = parseInt($('input[name="qty"]').val()) || 0;
                if (qty > stok) {
                    alert('Qty melebihi stok!');
                    $('button[type="submit"]').prop('disabled', true);
                } else {
                    $('button[type="submit"]').prop('disabled', false);
                }
            });

            // Fungsi untuk menangani perubahan pada input qty
            $('input[name="qty"]').change(function() {
                // Hitung total harga berdasarkan qty * harga jual
                var hargaJual = parseInt($('input[name="harga_jual"]').val().replace(/\D/g, '')) ||
                    0; // Menggunakan 0 jika harga_jual tidak diisi
                var qty = parseInt($(this).val()) || 0; // Menggunakan 0 jika qty tidak diisi
                var berat = parseFloat($('input[name="berat"]').val()) || 0;
                var totalHarga = (berat * hargaJual) * qty;
                $('#total_harga').val(totalHarga.toLocaleString('id-ID'));

                // Validasi qty melebihi stok
                var stok = parseInt($('#stok').val());
                if (qty > stok) {
                    alert('Qty melebihi stok!');
                    $('button[type="submit"]').prop('disabled', true);
                } else {
                    $('button[type="submit"]').prop('disabled', false);
                }
            });
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
                <div class="breadcrumb-title pe-3">Penjualan</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Penjualan </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col">
                <div class="card border-top border-0 border-4 border-primary">
                    <div class="card-body p-5">

                        @if (session()->has('message'))
                            <div class="alert alert-info">
                                {{ session('message') }}
                            </div>
                        @endif
                        <div class="card-title d-flex align-items-center">
                            <div><i class="font-22 text-primary"></i>
                            </div>
                            <h5 class="mb-0 text-primary">Form Tambah Penjualan</h5>
                        </div>
                        <hr>
                        <form class="row g-3" action="{{ route('penjualan.store') }}" method="post">
                            @csrf

                            <!--      -->
                            <div class="col-12">
                                <label class="form-label">No Faktur</label>
                                <input type="text" readonly class="form-control" name="no_faktur"
                                    value="{{ $last_no }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Tgl Penjualan</label>
                                <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="tgl_penjualan"
                                    required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Perhiasan</label>
                                <select class="form-control" name="perhiasan_id" required>
                                    <option value="">Pilih Perhiasan</option>
                                    @foreach ($perhiasans as $perhiasan)
                                        <option value="{{ $perhiasan->id }}" data-harga="{{ $perhiasan->harga }}"
                                            data-stok="{{ $perhiasan->stok }}" data-berat="{{ $perhiasan->berat }}">
                                            {{ $perhiasan->nama }} /
                                            {{ $perhiasan->berat }} gr / Stok : {{ $perhiasan->stok }}
                                            </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Stok</label>
                                <input type="text" class="form-control" name="stok" id="stok" readonly>
                                <input type="hidden" name="berat" id="berat">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Harga Jual Pergram</label>
                                <input type="text" class="form-control rupiahInput" name="harga_jual" id="harga_jual">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Jumlah Barang</label>
                                <input type="text" class="form-control" name="qty">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Total Penjualan</label>
                                <input type="text" readonly class="form-control" name="total_harga" id="total_harga">
                            </div>
                            <div class="col-12 mt-5">
                                <button type="submit" class="btn btn-primary px-4" value="simpan_saja"
                                    name="simpan">Simpan Saja</button>
                                <button type="submit" class="btn btn-success px-4" value="repeat" name="simpan">Simpan &
                                    Tambahkan Lagi</button>
                                <a href="{{ route('penjualan.index') }}" class="btn btn-secondary px-4">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection