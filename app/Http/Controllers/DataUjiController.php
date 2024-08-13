<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Models\DataUji;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataUjiImport;

class DataUjiController extends Controller
{
    public function index()
    {
        $dataUji = DataUji::all();
        return view('data-uji.index', compact('dataUji'));
    }

    public function destroy($id)
    {
        $dataUji = DataUji::findOrFail($id);
        $dataUji->delete();

        return redirect()->route('data-uji.index')->with('success', 'Data uji berhasil dihapus');
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls'
    ]);

    $file = $request->file('file');
    $data = Excel::toArray(new DataUjiImport, $file); // Langsung gunakan DataUjiImport untuk pemetaan

    if (!empty($data)) { // Tidak perlu memeriksa $data[0] lagi
        // Hapus data berdasarkan bulan dan tahun jika ada (opsional)
        $bulan = $data[0][0]['bulan'] ?? null; // Gunakan null coalescing operator
        $tahun = $data[0][0]['tahun'] ?? null;

        if ($bulan && $tahun) {
            DataUji::where('bulan', $bulan)->where('tahun', $tahun)->delete();
        }

        // Import data dengan penanganan kesalahan lebih baik
        try {
            Excel::import(new DataUjiImport, $file);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: {$failure->errors()[0]}";
            }
            return redirect()->route('data-uji.index')->with('error', implode("<br>", $errorMessages));
        }

        return redirect()->route('data-uji.index')->with('success', 'Data uji berhasil diimport');
    } else {
        return redirect()->route('data-uji.index')->with('error', 'File Excel kosong.');
    }
}

}
