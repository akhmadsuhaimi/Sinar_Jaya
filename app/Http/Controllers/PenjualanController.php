<?php

namespace App\Http\Controllers;

use App\Models\HasilPrediksi;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\JenisProduk;
use App\Models\Perhiasan;
use App\Models\Dataset;
use App\Models\DataUji;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    public function index()
    {
        $datas = Penjualan::orderBy('created_at', 'DESC')->get();
        return view('penjualan.index', compact(['datas']));
    }

    public function create()
    {
        $perhiasans = Perhiasan::get();
        $last = Penjualan::orderBy('no_faktur', 'DESC')->first();

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
        return view('penjualan.create', compact('perhiasans', 'last_no'));
    }

    public function store(Request $request)
    {
        Penjualan::create([
            'no_faktur' => $request->no_faktur,
            'tgl_penjualan' => $request->tgl_penjualan,
            'perhiasan_id' => $request->perhiasan_id,
            'qty' => $request->qty,
            'harga_jual' => str_replace('.', '', $request->harga_jual)
        ]);

        $stok = Perhiasan::where('id', $request->perhiasan_id)->first();
        $stok_awal = $stok->stok;
        $stok_now = $stok_awal - $request->qty;
        $stok->update(['stok' => $stok_now]);

        $bulan = Carbon::parse($request->tgl_penjualan)->format('m');
        $tahun = Carbon::parse($request->tgl_penjualan)->format('Y');

        $dataset = Dataset::where('perhiasan_id', $request->perhiasan_id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        $terjual = $dataset ? $dataset->terjual + $request->qty : $request->qty;
        $stok_sisa = $stok_awal - $terjual;
        $hasil = $stok_sisa < ($stok_awal * 0.5) ? 'Kurang' : 'Cukup';

        $keterangan = $hasil == 'Cukup'
            ? 'Stok perhiasan ini cukup untuk bulan ini. Pertimbangkan untuk mempertahankan jumlah stok atau menyesuaikan sedikit berdasarkan penjualan selanjutnya.'
            : 'Stok perhiasan ini kurang dan perlu ditambah. Permintaan tinggi menunjukkan bahwa produk ini populer. Pertimbangkan untuk menambah stok untuk bulan berikutnya.';

        if ($dataset) {
            $dataset->terjual = $terjual;
            $dataset->hasil = $hasil;
            $dataset->keterangan = $keterangan;
            $dataset->save();
        } else {
            Dataset::create([
                'perhiasan_id' => $request->perhiasan_id,
                'nama_barang' => $stok->nama,
                'kategori' => $stok->jenisproduk->jenis,
                'karat' => $stok->jenisproduk->kadar,
                'gram' => $stok->berat,
                'harga' => str_replace('.', '', $stok->harga),
                'stok' => $stok_awal,
                'terjual' => $terjual,
                'hasil' => $hasil,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'keterangan' => $keterangan
            ]);
        }

        if ($request->simpan == 'repeat') {
            return redirect()->route('penjualan.create')->with(['message' => 'Data Berhasil disimpan']);
        } else {
            return redirect()->route('penjualan.index')->with(['message' => 'Data Berhasil disimpan']);
        }
    }




    public function edit($id)
    {
        $perhiasans = Perhiasan::get();
        $data = Penjualan::where('id', $id)->first();
        return view('penjualan.edit', compact(['data', 'perhiasans']));
    }

    public function update(Request $request, $id)
    {
        Penjualan::where('id', $id)->update([
            'harga_jual' => str_replace('.', '', $request->harga_jual),
            'tgl_penjualan' => $request->tgl_penjualan
        ]);

        return redirect()->route('penjualan.index')->with(['message' => 'Data Berhasil diubah']);
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::where('id', $id)->first();
        $stok = Perhiasan::where('id', $penjualan->perhiasan_id)->first();
        $stok_now = $stok->stok + $penjualan->qty;
        $stok->update(['stok' => $stok_now]);
        $penjualan->delete();

        return redirect()->route('penjualan.index')->with(['message' => 'Data Berhasil dihapus']);
    }

    public function laporanPenjualan()
    {
        return view('penjualan.laporan');
    }

    public function filterLaporanPenjualan(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $penjualan = Penjualan::whereBetween('tgl_penjualan', [$startDate, $endDate])->get();

        return view('penjualan.print', compact('penjualan', 'startDate', 'endDate'));
    }
    public function prediksiRestock()
    {
        $bulan = Carbon::now()->addMonth()->format('m');
        $tahun = Carbon::now()->format('Y');
        return view('penjualan.prediksi', compact('bulan', 'tahun'));
    }

    public function filterPrediksi(Request $request)
    {
        $bulan_dipilih = $request->input('bulan');
        $tahun_dipilih = $request->input('tahun');

        $previousDate = Carbon::create($tahun_dipilih, $bulan_dipilih)->subMonth();
        $previousMonth = $previousDate->format('m');
        $previousYear = $previousDate->format('Y');

        $datasets = Dataset::where('bulan', $previousMonth)
            ->where('tahun', $previousYear)
            ->get();

        if ($datasets->isEmpty()) {
            return redirect()->route('penjualan.prediksi')->with('error', "Tidak ada data untuk bulan $previousMonth tahun $previousYear. Tidak bisa melakukan prediksi untuk bulan $bulan_dipilih tahun $tahun_dipilih.");
        }

        // $allPerhiasan = Perhiasan::all();
        // $datasetPerhiasanIds = $datasets->pluck('perhiasan_id')->toArray();

        // foreach ($allPerhiasan as $perhiasan) {
        //     if (!in_array($perhiasan->id, $datasetPerhiasanIds)) {
        //         return redirect()->route('penjualan.prediksi')->with('error', "Ada perhiasan yang tidak terjual di bulan $previousMonth tahun $previousYear. Anda tidak bisa melakukan prediksi di bulan $bulan_dipilih tahun $tahun_dipilih.");
        //     }
        // }

        $cukup_count = $datasets->where('hasil', 'Cukup')->count();
        $kurang_count = $datasets->where('hasil', 'Kurang')->count();
        $total_data = $datasets->count();

        $prob_cukup = $cukup_count / $total_data;
        $prob_kurang = $kurang_count / $total_data;

        $prob_cukup_fitur = ['kategori' => [], 'karat' => [], 'gram' => [], 'stok' => []];
        $prob_kurang_fitur = ['kategori' => [], 'karat' => [], 'gram' => [], 'stok' => []];

        foreach (['kategori', 'karat', 'gram', 'stok'] as $feature) {
            foreach ($datasets->unique($feature) as $value) {
                $value = $value->$feature;
                $cukup_fitur_count = $datasets->where('hasil', 'Cukup')->where($feature, $value)->count();
                $kurang_fitur_count = $datasets->where('hasil', 'Kurang')->where($feature, $value)->count();

                $prob_cukup_fitur[$feature][$value] = [
                    'prob' => ($cukup_fitur_count + 1) / ($cukup_count + $datasets->unique($feature)->count()),
                    'count' => $cukup_fitur_count
                ];

                $prob_kurang_fitur[$feature][$value] = [
                    'prob' => ($kurang_fitur_count + 1) / ($kurang_count + $datasets->unique($feature)->count()),
                    'count' => $kurang_fitur_count
                ];
            }
        }

        $results = [];

        foreach ($datasets as $data_uji) {
            $prob_cukup_uji = $prob_cukup;
            $prob_kurang_uji = $prob_kurang;
            foreach (['kategori', 'karat', 'gram', 'stok'] as $feature) {
                $value = $data_uji->$feature;
                $prob_cukup_uji *= $prob_cukup_fitur[$feature][$value]['prob'] ?? 1 / ($cukup_count + $datasets->unique($feature)->count());
                $prob_kurang_uji *= $prob_kurang_fitur[$feature][$value]['prob'] ?? 1 / ($kurang_count + $datasets->unique($feature)->count());
            }
            $hasil = $prob_cukup_uji > $prob_kurang_uji ? 'Cukup' : 'Kurang';

            $stok_awal = $data_uji->stok;
            $stok_sisa = $data_uji->stok - $data_uji->terjual;
            $prediksi_restock = max(0, $stok_awal - $stok_sisa);

            $estimasi_harga = $hasil == 'Cukup' ? '-' : $prediksi_restock * $data_uji->gram * $data_uji->harga;

            $results[] = [
                'nama_barang' => $data_uji->nama_barang,
                'kategori' => $data_uji->kategori,
                'karat' => $data_uji->karat,
                'gram' => $data_uji->gram,
                'harga' => $data_uji->harga,
                'stok' => $data_uji->stok,
                'terjual' => $data_uji->terjual,
                'hasil' => $hasil,
                'bulan' => $bulan_dipilih,
                'tahun' => $tahun_dipilih,
                'keterangan' => $data_uji->keterangan,
                'prediksi_restock' => $prediksi_restock,
                'estimasi_harga' => $estimasi_harga,
            ];

            HasilPrediksi::create([
                'nama_barang' => $data_uji->nama_barang,
                'kategori' => $data_uji->kategori,
                'karat' => $data_uji->karat,
                'gram' => $data_uji->gram,
                'harga' => $data_uji->harga,
                'stok' => $data_uji->stok,
                'terjual' => $data_uji->terjual,
                'hasil' => $hasil,
                'bulan' => $bulan_dipilih,
                'tahun' => $tahun_dipilih,
                'keterangan' => $data_uji->keterangan,
                'prediksi_restock' => $prediksi_restock,
                'estimasi_harga' => $estimasi_harga,
            ]);
        }

        return view('penjualan.prediksi', compact('datasets', 'results', 'bulan_dipilih', 'tahun_dipilih'));
    }

}
