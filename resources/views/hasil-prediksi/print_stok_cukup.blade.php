<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LAPORAN STOK CUKUP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            background-color: #fff;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            margin: 0;
            padding: 0;
        }

        * {
            font-family: "Arial";
        }

        .text-center {
            text-align: center;
        }

        h1 {
            font-size: 20px;
            margin: 0;
        }

        h3 {
            font-size: 14px;
            font-weight: normal;
            margin-top: -8px;
        }

        h4 {
            margin-top: 20px;
            text-transform: uppercase;
            margin-bottom: -10px;
        }

        .card {
            border: 1px solid #000;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            page-break-inside: avoid;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .card-text {
            margin: 5px 0;
        }

        .badge {
            padding: 5px;
            border-radius: 5px;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: black;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        #printButtonContainer {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1000;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .col-md-6 {
            flex: 0 0 48%;
            margin-bottom: 20px;
        }

        @media print {
            .sheet {
                margin: 0;
                box-shadow: 0;
            }

            .page-break {
                page-break-before: always;
            }

            #printButtonContainer {
                display: none;
            }
        }
    </style>
</head>

<body class="A4 potrait">
    <div id="printButtonContainer">
        <button id="printButton" class="btn btn-primary" onclick="window.print()">Print</button>
    </div>

    @php
        // Group by name and take the latest entry for each name
        $groupedHasilPrediksi = $hasilPrediksi->groupBy('nama_barang')
                                              ->map(function ($group) {
                                                  return $group->sortByDesc('id')->first();
                                              })
                                              ->values();
    @endphp

    @foreach($groupedHasilPrediksi->chunk(4) as $chunk)
    <section class="sheet padding-10mm">
        <div class="text-center">
            <img src="{{ asset('T4/assets/images/logo.png') }}" class="text-center">
        </div>
        <hr style="border-top: 2px solid black;">
        <hr style="border-top: 0.5px solid black; margin-top: -14px;">
        <h1 class="text-center">LAPORAN STOK CUKUP</h1>
        <p class="text-center">Bulan: {{ \Carbon\Carbon::createFromFormat('m', $bulan)->translatedFormat('F') }} Tahun: {{ $tahun }}</p>

        <div class="row">
            @foreach($chunk as $prediksi)
                @php
                    $data_previous = $datasetsPrevious->where('nama_barang', $prediksi->nama_barang)
                                                       ->where('karat', $prediksi->karat)
                                                       ->where('gram', $prediksi->gram)
                                                       ->first();
                    $terjual_sebelumnya = $data_previous ? $data_previous->terjual : 0;
                    $terjual_sekarang = $prediksi->terjual;

                    $status_pesan = '';
                    if ($terjual_sekarang > $terjual_sebelumnya) {
                        $status_pesan = 'Penjualan perhiasan ini <span class="badge badge-success">meningkat</span> dari bulan sebelumnya. Perhatikan stok terus agar tidak kehabisan.';
                    } elseif ($terjual_sekarang < $terjual_sebelumnya) {
                        if ($terjual_sebelumnya - $terjual_sekarang >= 3) {
                            $status_pesan = 'Penjualan perhiasan ini <span class="badge badge-danger">menurun drastis</span>. Sebaiknya perhiasan ini dilebur menjadi perhiasan yang paling banyak terjual bulan ini, yaitu <strong>' . ($bestSelling ? $bestSelling->nama_barang.' / Karat:'. $bestSelling->karat .' / Gram: '. $bestSelling->gram : 'Tidak tersedia') . '</strong>.';
                        } else {
                            $status_pesan = 'Penjualan perhiasan ini <span class="badge badge-warning">menurun</span>. Perhatikan stok dan strategi pemasaran.';
                        }
                    } else {
                        if ($prediksi->stok <= 5) {
                            $status_pesan = 'Penjualan perhiasan ini sama dengan bulan sebelumnya. Perhatikan stok untuk bulan selanjutnya.';
                        } else {
                            $status_pesan = 'Penjualan perhiasan ini stabil dan stok masih mencukupi. Pertahankan performa ini.';
                        }
                    }
                @endphp

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-title">{{ $prediksi->nama_barang }}</div>
                        <div class="card-text"><strong>Kategori:</strong> {{ $prediksi->kategori }}</div>
                        <div class="card-text"><strong>Karat:</strong> {{ $prediksi->karat }}</div>
                        <div class="card-text"><strong>Gram:</strong> {{ $prediksi->gram }}</div>
                        <div class="card-text"><strong>Stok:</strong> {{ $prediksi->stok }}</div>
                        <div class="card-text"><strong>Terjual Bulan Sebelumnya:</strong> {{ $terjual_sebelumnya }}</div>
                        <div class="card-text"><strong>Terjual Bulan Ini:</strong> {{ $terjual_sekarang }}</div>
                        <div class="card-text">{!! $status_pesan !!}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <table class="no-border" style="width: 200px; font-size: 11px; float: right; margin-top: 20px;">
            <tr>
                <th colspan="1">Banjarmasin,</th>
            </tr>
            <tr style="height: 100px;">
                <td style="width: 50%"></td>
            </tr>
            <tr>
                <td>Pimpinan<br></td>
            </tr>
        </table>
    </section>

    @if (!$loop->last)
    <div class="page-break"></div>
    @endif
    @endforeach
</body>
</html>
