<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Perhiasan;
use App\Models\JenisProduk;
use App\Models\Pembelian;
use App\Models\Penjualan;
use DB;
use Auth;
use Carbon\Carbon;

class StokController extends Controller
{
    //

    public function index()
    {
        $datas = Perhiasan::get();
        $pembelian = Pembelian::get();
        $penjualan = Penjualan::get();
        return view('stok.index',compact(['datas', 'pembelian', 'penjualan']));
    }
    public function printStokMenipis()
    {
        $datas = Perhiasan::where('stok', '<=', 5)
                          ->orderBy('stok', 'asc')
                          ->get();
        return view('stok.print_stok_menipis', compact(['datas']));
    }

    public function printPenjualanTerlaris()
    {
        $datas = Perhiasan::withCount(['penjualans' => function ($query) {
            $query->select(DB::raw('sum(qty)'));
        }])->orderBy('penjualans_count', 'desc')->get();

        return view('stok.print_penjualan_terlaris',compact(['datas']));
    }
}
