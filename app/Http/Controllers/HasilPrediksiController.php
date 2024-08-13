<?php

namespace App\Http\Controllers;

use App\Models\HasilPrediksi;
use App\Models\Dataset;
use App\Models\Perhiasan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HasilPrediksiController extends Controller
{
    public function index()
    {
        $hasilPrediksi = HasilPrediksi::all();
        return view('hasil-prediksi.index', compact('hasilPrediksi'));
    }

    public function show($id)
    {
        $hasilPrediksi = HasilPrediksi::findOrFail($id);
        $datasets = Dataset::all();

        $cukup_count = $datasets->where('hasil', 'Cukup')->count();
        $kurang_count = $datasets->where('hasil', 'Kurang')->count();
        $prob_cukup = $cukup_count / $datasets->count();
        $prob_kurang = $kurang_count / $datasets->count();

        $prob_details = $this->calculateProbabilities($hasilPrediksi, $datasets);

        return view('hasil-prediksi.show', compact('hasilPrediksi', 'cukup_count', 'kurang_count', 'prob_cukup', 'prob_kurang', 'prob_details'));
    }

    public function destroy($id)
    {
        $hasilPrediksi = HasilPrediksi::findOrFail($id);
        $hasilPrediksi->delete();

        return redirect()->route('hasil-prediksi.index')->with('success', 'Data hasil prediksi berhasil dihapus');
    }

    private function calculateProbabilities($dataUji, $datasets)
    {
        $cukup_count = $datasets->where('hasil', 'Cukup')->count();
        $kurang_count = $datasets->where('hasil', 'Kurang')->count();

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

        $prob_cukup_uji = $prob_cukup = $cukup_count / $datasets->count();
        $prob_kurang_uji = $prob_kurang = $kurang_count / $datasets->count();
        $prob_cukup_details = [$prob_cukup];
        $prob_kurang_details = [$prob_kurang];
        $prob_details = [];

        foreach (['kategori', 'karat', 'gram', 'stok'] as $feature) {
            $value = $dataUji->$feature;
            $prob_cukup_val = isset($prob_cukup_fitur[$feature][$value]) ? $prob_cukup_fitur[$feature][$value]['prob'] : 1 / ($cukup_count + $datasets->unique($feature)->count());
            $prob_kurang_val = isset($prob_kurang_fitur[$feature][$value]) ? $prob_kurang_fitur[$feature][$value]['prob'] : 1 / ($kurang_count + $datasets->unique($feature)->count());

            $cukup_fitur_count = isset($prob_cukup_fitur[$feature][$value]) ? $prob_cukup_fitur[$feature][$value]['count'] : 0;
            $kurang_fitur_count = isset($prob_kurang_fitur[$feature][$value]) ? $prob_kurang_fitur[$feature][$value]['count'] : 0;

            $prob_cukup_uji *= $prob_cukup_val;
            $prob_kurang_uji *= $prob_kurang_val;

            $prob_cukup_details[] = $prob_cukup_val;
            $prob_kurang_details[] = $prob_kurang_val;

            $prob_details[$feature] = [
                'value' => $value,
                'prob_cukup' => $prob_cukup_val,
                'prob_kurang' => $prob_kurang_val,
                'cukup_count' => $cukup_fitur_count,
                'kurang_count' => $kurang_fitur_count
            ];
        }

        return [
            'prob_cukup' => $prob_cukup_uji,
            'prob_kurang' => $prob_kurang_uji,
            'prob_cukup_details' => $prob_cukup_details,
            'prob_kurang_details' => $prob_kurang_details,
            'prob_details' => $prob_details,
        ];
    }

    public function print(Request $request)
    {
        $bulanTahun = $request->input('bulan_tahun');
        list($tahun, $bulan) = explode('-', $bulanTahun);

        $hasilPrediksi = HasilPrediksi::where('bulan', $bulan)->where('tahun', $tahun)->get();

        return view('hasil-prediksi.print', compact('hasilPrediksi', 'bulan', 'tahun'));
    }

    public function printStokKurang(Request $request)
    {
        $bulanTahun = $request->input('bulan_tahun');
        list($tahun, $bulan) = explode('-', $bulanTahun);
    
        $hasilPrediksi = HasilPrediksi::where('bulan', $bulan)
                                      ->where('tahun', $tahun)
                                      ->where('hasil', 'Kurang')
                                      ->get();
    
        if ($hasilPrediksi->isEmpty()) {
            return redirect()->back()->with('message', 'Tidak ada data untuk bulan dan tahun yang dipilih.');
        }
    
        $previousMonth = Carbon::create($tahun, $bulan)->subMonth();
        $datasetsPrevious = Dataset::where('bulan', $previousMonth->month)
                                   ->where('tahun', $previousMonth->year)
                                   ->get();
    
        $bestSelling = HasilPrediksi::where('bulan', $bulan)
                                    ->where('tahun', $tahun)
                                    ->orderByDesc('terjual')
                                    ->first();
    
        return view('hasil-prediksi.print_stok_kurang', compact('hasilPrediksi', 'bulan', 'tahun', 'datasetsPrevious', 'bestSelling'));
    }
        
    
    public function printStokCukup(Request $request)
    {
        $bulanTahun = $request->input('bulan_tahun');
        list($tahun, $bulan) = explode('-', $bulanTahun);
    
        $hasilPrediksi = HasilPrediksi::where('bulan', $bulan)
                                      ->where('tahun', $tahun)
                                      ->where('hasil', 'Cukup')
                                      ->get();
    
        if ($hasilPrediksi->isEmpty()) {
            return redirect()->back()->with('message', 'Tidak ada data untuk bulan dan tahun yang dipilih.');
        }
    
        $previousMonth = Carbon::create($tahun, $bulan)->subMonth();
        $datasetsPrevious = Dataset::where('bulan', $previousMonth->month)
                                   ->where('tahun', $previousMonth->year)
                                   ->get();
    
        $bestSelling = HasilPrediksi::where('bulan', $bulan)
                                    ->where('tahun', $tahun)
                                    ->orderByDesc('terjual')
                                    ->first();
    
        return view('hasil-prediksi.print_stok_cukup', compact('hasilPrediksi', 'bulan', 'tahun', 'datasetsPrevious', 'bestSelling'));
    }
        
}
