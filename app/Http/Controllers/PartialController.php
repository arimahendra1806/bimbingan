<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DosPemModel;
use App\Models\TahunAjaran;
use App\Models\DosPemMateriModel;
use App\Models\BimbinganModel;
use App\Models\RiwayatBimbinganModel;
use App\Models\User;
use DataTables, Auth;

class PartialController extends Controller
{
    public function MateriKonsul(Request $request, $jenis)
    {
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data mahasiswa login */
        $user = User::with('mahasiswa.dospem')->find(Auth::user()->id);

        /* Ambil data tabel dos_pem materi */
        if ($request->ajax()){
            $data = DosPemMateriModel::where('dosen_id', $user->mahasiswa->dospem->dosen_id)
                ->where('tahun_ajaran_id', $tahun_id->id)
                ->where('jenis_materi', $jenis)
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-info" id="btnDownload" data-toggle="tooltip" title="Download Ketentuan" data-id="'.$model->id.'" href="/dokumen/pembimbing-materi/'.$model->file_materi.'" download><i class="fas fa-download"></i></a>';
                    return $btn;
                })
                ->toJson();
        }

        /* return json */
        return response()->json();
    }

    public function RiwayatKonsul(Request $request, $jenis)
    {
        /* Ambil data mahasiswa login */
        $user = User::with('mahasiswa.dospem.bimbingan')->find(Auth::user()->id);

        /* Ambil data tabel riwayat bimbingan */
        if ($request->ajax()){
            $data = RiwayatBimbinganModel::where('bimbingan_kode', $user->mahasiswa->dospem->bimbingan->kode_bimbingan)
                ->where('bimbingan_jenis', $jenis)
                ->get();
            return DataTables::of($data)->addIndexColumn()->toJson();
        }

        /* return json */
        return response()->json();
    }
}
