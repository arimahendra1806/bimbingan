<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\DosPemModel;
use App\Models\DosenModel;
use DataTables;
use Auth;

class DataPembimbingController extends Controller
{
    public function indexMhs(Request $request){
        /* Get data Tahun */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Get data User Identitas */
        $identitas = Auth::user()->identitas_id;

        if ($request->ajax()){
            $data = DosPemModel::where('tahun_ajaran_id', $tahun_id->id)->where('nim', $identitas)->get()->load('dosen');
            return DataTables::of($data)
                ->addIndexColumn()
                ->toJson();
        }
        return view('mahasiswa.data-pembimbing.index');
    }
}
