<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\JenisProduk;
use DB;
use Auth;
use Carbon\Carbon;

class JenisProdukController extends Controller
{
    //

    public function index()
    {
        $datas = JenisProduk::get();
        return view('jenisproduk.index',compact(['datas']));
    }

    public function create()
    {

        return view('jenisproduk.create');
    }
    public function store(Request $request)
    {
        $existingJenis = JenisProduk::where('jenis', $request->jenis)
            ->where('kadar', $request->kadar)
            // ->where('jenis_id', $request->jenis_id)
            ->first();

        if ($existingJenis) {
            return redirect()->back()->withInput()->with('message', 'Kombinasi jenis produk, dan kadar sudah ada.');
        }

        JenisProduk::create([
            'jenis' => $request->jenis,
            'kadar' => $request->kadar
        ]);


        // JenisProduk::create([
        //     'jenis' => $request->jenis,
        //     'kadar' => $request->kadar
        // ]);

        return redirect()->route('jenisproduk.index')->with(['message' => 'Data Berhasil disimpan']);
    
    }
    public function edit($id)
    {

        $data = JenisProduk::where('id', $id)->first();
        return view('jenisproduk.edit',compact(['data']));
    }
    public function update(Request $request, $id)
    {

        JenisProduk::where('id', $id)->update([
            'jenis' => $request->jenis,
            'kadar' => $request->kadar
        ]);

        return redirect()->route('jenisproduk.index')->with(['message' => 'Data Berhasil diubah']);
    
    }
    public function destroy($id)
    {


         JenisProduk::where('id', $id)->delete();

        return redirect()->route('jenisproduk.index')->with(['message' => 'Data Berhasil dihapus']);
    
    }

}
