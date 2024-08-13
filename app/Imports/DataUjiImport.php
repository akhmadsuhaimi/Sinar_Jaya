<?php

namespace App\Imports;

use App\Models\DataUji;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataUjiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['nama_barang'], $row['kategori'], $row['karat'], $row['gram'], $row['stok'], $row['hasil'], $row['terjual'], $row['harga'], $row['bulan'], $row['tahun'])) {
            return null; 
        }

        return new DataUji([
            'nama_barang' => $row['nama_barang'],
            'kategori' => $row['kategori'],
            'karat' => $row['karat'],
            'gram' => $row['gram'],
            'stok' => $row['stok'],
            'hasil' => $row['hasil'],
            'terjual' => $row['terjual'],
            'harga' => $row['harga'],
            'bulan' => $row['bulan'],
            'tahun' => $row['tahun']
        ]);
    }
}
