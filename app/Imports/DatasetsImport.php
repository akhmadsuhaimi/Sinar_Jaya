<?php

namespace App\Imports;

use App\Models\Dataset;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DatasetsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Dataset([
            'nama_barang' => $row['nama_barang'],
            'kategori' => $row['kategori'],
            'karat' => $row['karat'],
            'gram' => $row['gram'],
            'harga' => $row['harga'],
            'stok' => $row['stok'],
            'hasil' => $row['hasil'],
        ]);
    }
}
