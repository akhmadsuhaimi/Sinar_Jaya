<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\Perhiasan;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahunDipilih = $request->input('tahun', Carbon::now()->year);

        $penjualanTahunIni = Penjualan::whereYear('tgl_penjualan', $tahunDipilih)->sum('qty');

        $pembelianTahunIni = Pembelian::whereYear('tgl_pembelian', $tahunDipilih)->sum('qty');

        $totalPerhiasan = Perhiasan::count();

        $bulanPenjualan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $jumlahPenjualanPerBulan = Penjualan::select(DB::raw('MONTH(tgl_penjualan) as bulan'), DB::raw('SUM(qty) as jumlah'))
            ->whereYear('tgl_penjualan', $tahunDipilih)
            ->groupBy(DB::raw('MONTH(tgl_penjualan)'))
            ->orderBy(DB::raw('MONTH(tgl_penjualan)'))
            ->pluck('jumlah', 'bulan')
            ->toArray();

        $jumlahPenjualanPerBulan = array_replace(array_fill_keys(range(1, 12), 0), $jumlahPenjualanPerBulan);
        $jumlahPenjualanPerBulan = array_values($jumlahPenjualanPerBulan);

        return view('dashboard.dashboard', compact(
            'penjualanTahunIni', 
            'pembelianTahunIni', 
            'totalPerhiasan', 
            'bulanPenjualan', 
            'jumlahPenjualanPerBulan',
            'tahunDipilih'
        ));
    }
}

