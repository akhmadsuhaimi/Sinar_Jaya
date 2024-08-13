<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPrediksi extends Model
{
    use HasFactory;

    protected $table = 'hasil_prediksi';

    protected $fillable = [
        'nama_barang',
        'kategori',
        'karat',
        'gram',
        'harga',
        'stok',
        'terjual',
        'hasil',
        'bulan',
        'tahun',
        'keterangan',
        'prediksi_restock',
        'estimasi_harga',
    ];

    public $timestamps = false;
}
