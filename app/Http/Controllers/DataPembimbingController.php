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
}
