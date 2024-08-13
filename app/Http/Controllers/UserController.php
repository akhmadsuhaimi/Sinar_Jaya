<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Cabang;
use DB;
use Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    //

    public function index()
    {
        $datas = User::orderBy('id', 'ASC')->get();
        return view('user.index',compact(['datas']));
    }

    public function create()
    {

        return view('user.create');
    }
    public function store(Request $request)
    {

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'level' => $request->level,
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('user.index')->with(['message' => 'Data Berhasil disimpan']);
    
    }
    public function edit($id)
    {

       
        $data = User::where('id', $id)->first();
        return view('user.edit',compact(['data']));
    }
    public function update(Request $request, $id)
    {
        if($request->get('password')) {


         User::where('id', $id)->update([
               'name' => $request->name,
            'email' => $request->email,
            'level' => $request->level,
            'password' => bcrypt($request->password)

        ]);
        } else {

            User::where('id', $id)->update([
               'name' => $request->name,
            'email' => $request->email,
            'level' => $request->level

        ]);

        }


        return redirect()->route('user.index')->with(['message' => 'Data Berhasil diubah']);
    
    }
    public function destroy($id)
    {


         User::where('id', $id)->delete();

        return redirect()->route('user.index')->with(['message' => 'Data Berhasil dihapus']);
    
    }


}
