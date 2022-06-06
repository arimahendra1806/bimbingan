<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DosPemModel;
use App\Models\TahunAjaran;
use App\Exports\JudulExport;
use DataTables, Validator;

class JudulMahasiswaController extends Controller
{
    public function indexKoor(Request $request){
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::all()->sortByDesc('tahun_ajaran');
        $th_aktif = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data tabel dos_pem */
        if ($request->ajax()){
            $data = DosPemModel::latest()->get()->load('tahun', 'dosen', 'mahasiswa', 'judul');
            return DataTables::of($data)
                ->addIndexColumn()
                ->toJson();
        }

        /* Return menuju view */
        return view('koordinator.judul-mahasiswa.index', compact('tahun_id','th_aktif'));
    }

    public function exportKoor($params){
        $tahun = $params;
        $filename = time()."_Daftar_Judul.xlsx";

        return Excel::download(new JudulExport($tahun), $filename);
    }

    public function indexKaprodi(Request $request){
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data tabel dos_pem */
        if ($request->ajax()){
            $data = DosPemModel::where('tahun_ajaran_id', $tahun_id->id)->latest()->get()->load('tahun', 'dosen', 'mahasiswa', 'judul');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-info" id="btnShow" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        /* Return menuju view */
        return view('kaprodi.data-pembimbing.index');
    }

    public function show($data_pembimbing)
    {
        /* Ambil data Mahasiswa sesuai parameter */
        $data = DosPemModel::find($data_pembimbing)->load('tahun', 'dosen', 'mahasiswa', 'judul.anggota');

        /* Return json data Mahasiswa */
        return response()->json($data);
    }
}
