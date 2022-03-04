<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DosPemModel;
use App\Models\TahunAjaran;
use App\Exports\JudulExport;
use DataTables;

class JudulMahasiswaController extends Controller
{
    public function indexKoor(Request $request){
        /* Get data Tahun_id */
        $tahun_id = TahunAjaran::all()->sortByDesc('tahun_ajaran');

        if ($request->ajax()){
            $data = DosPemModel::latest()->get()->load('tahun', 'dosen', 'mahasiswa', 'judul');
            return DataTables::of($data)
                ->addIndexColumn()
                ->toJson();
        }
        return view('koordinator.judul-mahasiswa.index', compact('tahun_id'));
    }

    public function exportKoor(Request $request){
        $request->validate([
            'tahun_ajaran' => 'required'
        ]);

        $tahun = $request->tahun_ajaran;
        $filename = time()."_Daftar_Judul.xlsx";
        $filepath = ('/dokumen/export/daftar-judul/');

        Excel::store(new JudulExport($tahun), $filename, 'export_judul');

        $data = $filepath.$filename;

        return response()->json($data);
    }
}
