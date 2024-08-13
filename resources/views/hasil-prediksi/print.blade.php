<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LAPORAN STOK KURANG</title>
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

        #printButtonContainer {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1000;
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
    <section class="sheet padding-10mm">
        <div class="text-center">
            <img src="{{ asset('T4/assets/images/logo.png') }}" class="text-center">
        </div>
        <hr style="border-top: 2px solid black;">
        <hr style="border-top: 0.5px solid black; margin-top: -14px;">
        <h1 class="text-center">LAPORAN STOK KURANG</h1>
        <p class="text-center">Bulan: {{ \Carbon\Carbon::createFromFormat('m', $bulan)->translatedFormat('F') }} Tahun: {{ $tahun }}</p>

        @foreach($perhiasans as $perhiasan)
            @php
                $prediksi_terakhir = $hasilPrediksi->where('nama_barang', $perhiasan->nama_barang)->last();
                $data_previous = $datasetsPrevious->where('nama_barang', $perhiasan->nama_barang)->first();
                $status_pesan = '';
                $terjual_sebelumnya = $data_previous ? $data_previous->terjual : 0;
                $terjual_sekarang = $prediksi_terakhir ? $prediksi_terakhir->terjual : 0;
                
                if ($terjual_sekarang > $terjual_sebelumnya) {
                    $status_pesan = 'Penjualan perhiasan ini meningkat dari bulan sebelumnya. Perhatikan stok terus agar tidak kehabisan.';
                } elseif ($terjual_sekarang < $terjual_sebelumnya) {
                    $status_pesan = 'Penjualan perhiasan ini menurun drastis. Sebaiknya perhiasan ini dilebur menjadi perhiasan yang paling banyak terjual bulan ini.';
                } else {
                    $status_pesan = 'Penjualan perhiasan ini sama dengan bulan sebelumnya. Perhatikan stok untuk bulan selanjutnya.';
                }
            @endphp

            @if($prediksi_terakhir && $prediksi_terakhir->hasil == 'Kurang')
                <div class="card">
                    <div class="card-title">{{ $perhiasan->nama_barang }}</div>
                    <div class="card-text">Kategori: {{ $prediksi_terakhir->kategori }}</div>
                    <div class="card-text">Karat: {{ $prediksi_terakhir->karat }}</div>
                    <div class="card-text">Gram: {{ $prediksi_terakhir->gram }}</div>
                    <div class="card-text">Harga: {{ number_format($prediksi_terakhir->harga, 2, ',', '.') }}</div>
                    <div class="card-text">Stok: {{ $prediksi_terakhir->stok }}</div>
                    <div class="card-text">Terjual Bulan Sebelumnya: {{ $terjual_sebelumnya }}</div>
                    <div class="card-text">Terjual Bulan Ini: {{ $terjual_sekarang }}</div>
                    <div class="card-text">{{ $status_pesan }}</div>
                </div>
            @endif
        @endforeach

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
</body>
</html>
