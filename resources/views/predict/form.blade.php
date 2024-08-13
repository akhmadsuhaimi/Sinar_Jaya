@extends('layout.master')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Prediksi</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Form Prediksi</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="col">
            <div class="card">
                <div class="card-header text-white">
                    <h5 class="card-title">Form Prediksi</h5>
                </div>
                <div class="card-body">
                    <form id="predictForm" class="row g-3">
                        @csrf
                        <div class="col-md-6">
                            <label for="nama_barang" class="form-label">Nama Barang:</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                        </div>
                        <div class="col-md-6">
                            <label for="kategori" class="form-label">Kategori:</label>
                            <select class="form-control" id="kategori" name="kategori" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($kategori as $item)
                                    <option value="{{ $item->kategori }}">{{ $item->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="karat" class="form-label">Karat:</label>
                            <select class="form-control" id="karat" name="karat" required>
                                <option value="" disabled selected>Pilih Karat</option>
                                @foreach($karat as $item)
                                    <option value="{{ $item->karat }}">{{ $item->karat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="gram" class="form-label">Gram:</label>
                            <select class="form-control" id="gram" name="gram" required>
                                <option value="" disabled selected>Pilih Gram</option>
                                @foreach($gram as $item)
                                    <option value="{{ $item->gram }}">{{ $item->gram }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="harga" class="form-label">Harga:</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                        </div>
                        <div class="col-md-6">
                            <label for="stok" class="form-label">Stok:</label>
                            <input type="number" class="form-control" id="stok" name="stok" required>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" onclick="predict()">Prediksi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="predictModal" tabindex="-1" aria-labelledby="predictModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="predictModalLabel">Hasil Prediksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Nama Barang: <span id="namaBarang"></span></h4>
                <h5>Hasil Prediksi: <span id="hasilPrediksi" class="badge"></span></h5>
                <div class="mt-3">
                    <h5>Probabilitas Prior</h5>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Jumlah Cukup</td>
                                <td id="jumlahCukup"></td>
                            </tr>
                            <tr>
                                <td>Jumlah Kurang</td>
                                <td id="jumlahKurang"></td>
                            </tr>
                            <tr>
                                <td>P(Y=Cukup)</td>
                                <td id="priorCukup"></td>
                                <td>P(Y=Cukup) = <span id="priorCukupFormula"></span></td>
                            </tr>
                            <tr>
                                <td>P(Y=Kurang)</td>
                                <td id="priorKurang"></td>
                                <td>P(Y=Kurang) = <span id="priorKurangFormula"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <h5>Probabilitas Kondisional</h5>
                    <table class="table table-bordered" id="conditionalProbTable">
                        <thead>
                            <tr>
                                <th>Fitur</th>
                                <th>Nilai</th>
                                <th>Jumlah Cukup</th>
                                <th>Jumlah Kurang</th>
                                <th>P(Fitur | Y=Cukup)</th>
                                <th>P(Fitur | Y=Kurang)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Kondisional probabilitas akan dimuat di sini -->
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <h5>Probabilitas Total</h5>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>P(X | Y=Cukup) * P(Y=Cukup)</td>
                                <td id="totalCukup"></td>
                                <td>P(X | Y=Cukup) * P(Y=Cukup) = <span id="totalCukupFormula"></span></td>
                            </tr>
                            <tr>
                                <td>P(X | Y=Kurang) * P(Y=Kurang)</td>
                                <td id="totalKurang"></td>
                                <td>P(X | Y=Kurang) * P(Y=Kurang) = <span id="totalKurangFormula"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    function predict() {
        var form = $('#predictForm');
        $.ajax({
            url: '{{ route("predict.predict") }}',
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('#namaBarang').text(response.nama_barang);
                $('#hasilPrediksi').text(response.hasil)
                    .removeClass('bg-success bg-danger')
                    .addClass(response.hasil === 'Cukup' ? 'bg-success' : 'bg-danger');
                $('#jumlahCukup').text(response.cukup_count);
                $('#jumlahKurang').text(response.kurang_count);
                $('#priorCukup').text(response.prior_cukup.toFixed(4));
                $('#priorKurang').text(response.prior_kurang.toFixed(4));
                $('#priorCukupFormula').text(`${response.cukup_count} / ${response.cukup_count + response.kurang_count}`);
                $('#priorKurangFormula').text(`${response.kurang_count} / ${response.cukup_count + response.kurang_count}`);
                $('#totalCukup').text(response.prob_cukup.toFixed(10));
                $('#totalKurang').text(response.prob_kurang.toFixed(10));
                $('#totalCukupFormula').text(response.prob_cukup_details.map((v) => v.toFixed(4)).join(' * '));
                $('#totalKurangFormula').text(response.prob_kurang_details.map((v) => v.toFixed(4)).join(' * '));

                var conditionalProbHtml = '';
                for (var feature in response.prob_details) {
                    conditionalProbHtml += `
                        <tr>
                            <td>${feature.charAt(0).toUpperCase() + feature.slice(1)}</td>
                            <td>${response.prob_details[feature].value}</td>
                            <td>${response.prob_details[feature].cukup_count}</td>
                            <td>${response.prob_details[feature].kurang_count}</td>
                            <td>${response.prob_details[feature].prob_cukup.toFixed(4)}</td>
                            <td>${response.prob_details[feature].prob_kurang.toFixed(4)}</td>
                        </tr>
                    `;
                }
                $('#conditionalProbTable tbody').html(conditionalProbHtml);

                $('#predictModal').modal('show');
            }
        });
    }
</script>
@stop
@endsection
