<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Perhiasan;
use App\Models\JenisProduk;
use DB;
use Auth;
use Carbon\Carbon;

class PerhiasanController extends Controller
{
    //

    public function index()
    {
        $datas = Perhiasan::get();
        return view('perhiasan.index',compact(['datas']));
    }

    public function create()
    {
        $jenisproduks = JenisProduk::get();
        $last = Perhiasan::orderBy('kode', 'DESC')->first();  

        if($last) {
              $num = $last->kode +1;
                switch (strlen($num))
                {
                 case 1 : $NoTrans = "0000".$num; break;
                 case 2 : $NoTrans = "000".$num; break;
                 case 3 : $NoTrans = "00".$num; break;
                 case 4 : $NoTrans = "0".$num; break;
                default: $NoTrans = $num;   
                }
                $last_no = $NoTrans; 
        } else {
            $last_no = '00001'; 
        }
        return view('perhiasan.create', compact('jenisproduks', 'last_no'));
    }
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'kode' => 'required',
        //     'nama' => 'required',
        //     'berat' => 'required',
        //     'harga' => 'required',
        //     'jenis_id' => 'required',
        // ]);

        $existingPerhiasan = Perhiasan::where('nama', $request->nama)
            ->where('berat', $request->berat)
            ->where('jenis_id', $request->jenis_id)
            ->first();

        if ($existingPerhiasan) {
            return redirect()->back()->withInput()->with('message', 'Kombinasi nama, berat, dan jenis produk sudah ada.');
        }

        Perhiasan::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'berat' => $request->berat,
            'harga' => $request->harga,
            'jenis_id' => $request->jenis_id,
            'stok' => '0'
        ]);

        return redirect()->route('perhiasan.index')->with(['message' => 'Data Berhasil disimpan']);
    }
    public function edit($id)
    {

        $jenisproduks = JenisProduk::get();
        $data = Perhiasan::where('id', $id)->first();
        return view('perhiasan.edit',compact(['data', 'jenisproduks']));
    }
    public function update(Request $request, $id)
    {

        Perhiasan::where('id', $id)->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'berat' => $request->berat,
            'harga' => $request->harga,
            'jenis_id' => $request->jenis_id
        ]);

        return redirect()->route('perhiasan.index')->with(['message' => 'Data Berhasil diubah']);
    
    }
    public function destroy($id)
    {


         Perhiasan::where('id', $id)->delete();

        return redirect()->route('perhiasan.index')->with(['message' => 'Data Berhasil dihapus']);
    
    }

}
