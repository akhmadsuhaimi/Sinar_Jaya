<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perhiasan extends Model
{
    use HasFactory;
    protected $table = 'perhiasan';
    protected $primaryKey = "id";
    protected $fillable = ['kode', 'nama', 'berat', 'harga', 'jenis_id', 'stok'];
    protected $guarded = [];

    public function jenisproduk()
    {
        return $this->belongsTo(JenisProduk::class, 'jenis_id', 'id');
    }
    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'perhiasan_id', 'id');
    }
}
