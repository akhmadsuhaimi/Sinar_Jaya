<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelian';
    protected $primaryKey = "id";
    protected $fillable = ['no_faktur', 'tgl_pembelian', 'perhiasan_id', 'qty','harga_beli'];
    protected $guarded = [];

    public function perhiasan()
    {
        return $this->belongsTo(Perhiasan::class, 'perhiasan_id', 'id');
    }
}
