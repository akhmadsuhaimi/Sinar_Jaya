<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    use HasFactory;
    protected $table = 'data_set';
    protected $primaryKey = "id";
    protected $fillable = ['nama_barang', 'kategori', 'karat', 'gram', 'harga', 'stok', 'terjual', 'hasil', 'bulan', 'tahun', 'perhiasan_id', 'keterangan'];
}
