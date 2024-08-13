<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUji extends Model
{
    use HasFactory;

    protected $table = 'data_uji';

    protected $fillable = [
        'nama_barang',
        'kategori',
        'karat',
        'gram',
        'stok',
        'hasil',
        'terjual',
        'harga',
        'bulan',
        'tahun'
    ];
}
