<?php

namespace App\Http\Controllers;

use App\Imports\DatasetsImport;
use App\Models\Dataset;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DatasetController extends Controller
{
    public function index()
    {
        $datasets = Dataset::all();
        return view('datasets.index', compact('datasets'));
    }

    public function importForm()
    {
        return view('datasets.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        Dataset::truncate();
        
        Excel::import(new DatasetsImport, $request->file('file'));

        return redirect()->route('datasets.index')->with('success', 'Datasets imported successfully.');
    }
}
