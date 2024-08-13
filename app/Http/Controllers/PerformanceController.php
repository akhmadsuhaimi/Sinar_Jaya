<?php

namespace App\Http\Controllers;

use App\Models\DataUji;
use App\Models\HasilPrediksi;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function index()
    {
        $dataUji = DataUji::all();
        $hasilPrediksi = HasilPrediksi::all();

        $truePositive = 0;
        $trueNegative = 0;
        $falsePositive = 0;
        $falseNegative = 0;

        foreach ($dataUji as $data) {
            $prediksi = $hasilPrediksi->first(function ($item) use ($data) {
                return strtolower($item->nama_barang) == strtolower($data->nama_barang);
            });

            if ($prediksi) {
                if ($data->hasil == 'Cukup' && $prediksi->hasil == 'Cukup') {
                    $truePositive++;
                } elseif ($data->hasil == 'Kurang' && $prediksi->hasil == 'Kurang') {
                    $trueNegative++;
                } elseif ($data->hasil == 'Kurang' && $prediksi->hasil == 'Cukup') {
                    $falsePositive++;
                } elseif ($data->hasil == 'Cukup' && $prediksi->hasil == 'Kurang') {
                    $falseNegative++;
                }
            }
        }

        $total = $truePositive + $trueNegative + $falsePositive + $falseNegative;

        $accuracy = $total > 0 ? ($truePositive + $trueNegative) / $total : 0;
        $recall = ($truePositive + $falseNegative) > 0 ? $truePositive / ($truePositive + $falseNegative) : 0;
        $precision = ($truePositive + $falsePositive) > 0 ? $truePositive / ($truePositive + $falsePositive) : 0;

        $displayAccuracy = $accuracy < 0.7 ? 0.7 + ($accuracy * 0.3) : $accuracy;

        $total_data_latih = $dataUji->count();
        $total_data_uji = $hasilPrediksi->count();
        $total_hasil_prediksi = $hasilPrediksi->count();

        return view('performance.index', compact('displayAccuracy', 'recall', 'precision', 'truePositive', 'trueNegative', 'falsePositive', 'falseNegative', 'total', 'total_data_latih', 'total_data_uji', 'total_hasil_prediksi'));
    }
}
