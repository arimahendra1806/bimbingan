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

        /* Ambil data tabel dos_pem */
        if ($request->ajax()){
            $data = DosPemModel::latest()->get()->load('tahun', 'dosen', 'mahasiswa', 'judul');
            return DataTables::of($data)
                ->addIndexColumn()
                ->toJson();
        }

        /* Return menuju view */
        return view('koordinator.judul-mahasiswa.index', compact('tahun_id'));
    }

    public function exportKoor(Request $request){
        /* Peraturan validasi  */
        $rules = [
            'tahun_ajaran' => ['required']
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'tahun_ajaran' => 'Tahun Ajaran'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Expor data judul*/
            $tahun = $request->tahun_ajaran;
            $filename = time()."_Daftar_Judul.xlsx";
            $filepath = ('/dokumen/export/daftar-judul/');

            Excel::store(new JudulExport($tahun), $filename, 'export_judul');

            $data = $filepath.$filename;

            /* Return json berhasil */
            return response()->json(['link' => $data]);
        }
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
