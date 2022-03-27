<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\DosPemModel;
use App\Models\DosenModel;
use App\Models\User;
use DataTables;
use Auth;

class DataPembimbingController extends Controller
{
    public function indexMhs(Request $request){
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data mahasiswa login */
        $user = User::with('mahasiswa')->find(Auth::user()->id);
        $mhs_id = $user->mahasiswa->id;

        /* Ambil data tabel dosen pembimbing */
        if ($request->ajax()){
            $data = DosPemModel::where('tahun_ajaran_id', $tahun_id->id)->where('mahasiswa_id', $mhs_id)->get()->load('dosen');
            return DataTables::of($data)
                ->addIndexColumn()
                ->toJson();
        }

        /* Return menuju view */
        return view('mahasiswa.data-pembimbing.index');
    }

    public function indexDsn(Request $request){
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data mahasiswa login */
        $user = User::with('dosen')->find(Auth::user()->id);
        $dsn_id = $user->dosen->id;

        /* Ambil data tabel dosen pembimbing */
        if ($request->ajax()){
            $data = DosPemModel::where('tahun_ajaran_id', $tahun_id->id)->where('dosen_id', $dsn_id)->get()->load('mahasiswa','judul.anggota');
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
        return view('dosen.data-mahasiswa.index');
    }

    public function showDsn($id){
        /* Ambil data dos_pem sesuai parameter */
        $data = DosPemModel::find($id)->load('mahasiswa','judul.anggota');

        /* Return json berhasil */
        return response()->json($data);
    }
}
