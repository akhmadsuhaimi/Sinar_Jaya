<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pembelian;
use App\Models\JenisProduk;
use App\Models\Perhiasan;
use DB;
use Auth;
use Carbon\Carbon;

class PembelianController extends Controller
{
    //

    public function index()
    {
        $datas = Pembelian::orderBy('created_at', 'DESC')->get();
        return view('pembelian.index', compact(['datas']));
    }

    public function create()
    {
        $perhiasans = Perhiasan::get();
        $last = Pembelian::orderBy('no_faktur', 'DESC')->first();

        if ($last) {
            $num = $last->no_faktur + 1;
            switch (strlen($num)) {
                case 1:
                    $NoTrans = "0000" . $num;
                    break;
                case 2:
                    $NoTrans = "000" . $num;
                    break;
                case 3:
                    $NoTrans = "00" . $num;
                    break;
                case 4:
                    $NoTrans = "0" . $num;
                    break;
                default:
                    $NoTrans = $num;
            }
            $last_no = $NoTrans;
        } else {
            $last_no = '00001';
        }
        return view('pembelian.create', compact('perhiasans', 'last_no'));
    }
    public function store(Request $request)
    {
        Pembelian::create([
            'no_faktur' => $request->no_faktur,
            'tgl_pembelian' => $request->tgl_pembelian,
            'perhiasan_id' => $request->perhiasan_id,
            'qty' => $request->qty,
            'harga_beli' => $request->harga_beli
        ]);

        $stok = Perhiasan::where('id', $request->perhiasan_id)->first();
        $stok_now = $stok->stok + $request->qty;
        $stok->update(['stok' => $stok_now]);
        if ($request->simpan == 'repeat') {
            return redirect()->route('pembelian.create')->with(['message' => 'Data Berhasil disimpan']);
        } else {
            return redirect()->route('pembelian.index')->with(['message' => 'Data Berhasil disimpan']);
        }
    }
    public function edit($id)
    {
        $perhiasans = Perhiasan::get();
        $data = Pembelian::where('id', $id)->first();
        return view('pembelian.edit', compact(['data', 'perhiasans']));
    }
    public function update(Request $request, $id)
    {

        Pembelian::where('id', $id)->update([
            'harga_beli' => $request->harga_beli,
            'tgl_pembelian' => $request->tgl_pembelian
        ]);

        return redirect()->route('pembelian.index')->with(['message' => 'Data Berhasil diubah']);
    }
    public function destroy($id)
    {


        $pembelian = Pembelian::where('id', $id)->first();
        $stok = Perhiasan::where('id', $pembelian->perhiasan_id)->first();
        $stok_now = $stok->stok - $pembelian->qty;
        $stok->update(['stok' => $stok_now]);
        $pembelian->delete();

        return redirect()->route('pembelian.index')->with(['message' => 'Data Berhasil dihapus']);
    }
    public function filterLaporanPembelian(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $pembelian = Pembelian::whereBetween('tgl_pembelian', [$startDate, $endDate])->get();
    
        return view('pembelian.print', compact('pembelian', 'startDate', 'endDate'));
    }
}
