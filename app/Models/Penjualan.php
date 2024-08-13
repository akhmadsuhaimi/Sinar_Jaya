<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan';
    protected $primaryKey = "id";
    protected $fillable = ['no_faktur', 'tgl_penjualan', 'perhiasan_id', 'qty','harga_jual'];
    protected $guarded = [];

    public function perhiasan()
    {
        return $this->belongsTo(Perhiasan::class, 'perhiasan_id', 'id');
    }
}
