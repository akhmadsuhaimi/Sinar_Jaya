<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>LAPORAN STOK MENIPIS</title>
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

        td {
            padding: 5px !important;
            vertical-align: middle !important;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        table {
            font-size: 12px;
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
            border: 1px solid #000;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }

        .no-border {
            border: none !important;
        }

        .sheet {
            padding: 10mm;
        }

        .mt-1 {
            margin-top: 1rem;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-decoration-underline {
            text-decoration: underline;
        }

        .wrap-text {
            word-wrap: break-word;
            white-space: normal;
        }

        .stok-red {
            color: red !important;
        }

        .stok-orange {
            color: darkorange !important;
        }

        .stok-yellow {
            color: crimson !important;
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

            .stok-red {
                color: red !important;
            }

            .stok-orange {
                color: darkorange !important;
            }

            .stok-yellow {
                color: crimson !important;
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
    @php $counter = 1; @endphp
    @foreach ($datas->chunk(25) as $chunk)
        <section class="sheet padding-10mm">
            @if ($loop->first)
                <div class="text-center">
                    <img src="{{ asset('T4/assets/images/logo.png') }}" class="text-center">
                </div>
                <hr style="border-top: 2px solid black;">
                <hr style="border-top: 0.5px solid black; margin-top: -14px;">
                <h1 class="text-center">LAPORAN STOK MENIPIS</h1>
            @endif
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th class="border">No</th>
                        <th class="border">Kode</th>
                        <th class="border">Jenis</th>
                        <th class="border">Kadar</th>
                        <th class="border">Nama</th>
                        <th class="border">Pembelian</th>
                        <th class="border">Penjualan</th>
                        <th class="border">Sisa Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chunk as $item)
                        <tr>
                            <td class="border">{{ $counter++ }}</td>
                            <td class="border">{{ $item->kode }}</td>
                            <td class="border">{{ $item->jenisproduk->jenis ?? '-' }}</td>
                            <td class="border">{{ $item->jenisproduk->kadar ?? '-' }}</td>
                            <td class="border">{{ $item->nama }}</td>
                            <td class="border">{{ getTotalQtyPembelian($item->id) }}</td>
                            <td class="border">{{ getTotalQtyPenjualan($item->id) }}</td>
                            <td class="border">
                                <span
                                    class="{{ $item->stok == 0 ? 'stok-red' : ($item->stok <= 3 ? 'stok-orange' : ($item->stok <= 5 ? 'stok-yellow' : '')) }}">
                                    {{ $item->stok }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($loop->last)
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
            @endif
        </section>
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>
