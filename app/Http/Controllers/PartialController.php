<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DosPemModel;
use App\Models\TahunAjaran;
use App\Models\DosPemMateriModel;
use App\Models\BimbinganModel;
use App\Models\RiwayatBimbinganModel;
use DataTables;
use Auth;

class PartialController extends Controller
{
    public function MateriKonsul(Request $request, $jenis, $bab)
    {
        /* Get data User Identitas */
        $identitas = Auth::user()->identitas_id;

        /* Get data DosPem */
        $pembimbing_id = DosPemModel::where('nim', $identitas)->first();

        /* Get data Tahun */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        if ($request->ajax()){
            $data = DosPemMateriModel::where('nidn', $pembimbing_id->nidn)
                ->where('tahun_ajaran_id', $tahun_id->id)
                ->where('jenis_materi', $jenis)
                ->where('bab_materi', $bab)
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-info" id="btnDownload" data-toggle="tooltip" title="Download Ketentuan" data-id="'.$model->id.'" href="/dokumen/pembimbing-materi/'.$model->file_materi.'" download><i class="fas fa-download"></i></a>';
                    return $btn;
                })
                ->toJson();
        }
        return response()->json();
    }

    public function RiwayatKonsul(Request $request, $jenis, $bab)
    {
        /* Get data User Identitas */
        $identitas = Auth::user()->identitas_id;

        /* Get data DosPem */
        $pembimbing_id = DosPemModel::where('nim', $identitas)->first();

        /* Get data Bimbingan */
        $bimbingan_id = BimbinganModel::where('pembimbing_kode', $pembimbing_id->kode_pembimbing)->first();
        if(empty($bimbingan_id)){
            $kb = "0";
        } else {
            $kb = $bimbingan_id->kode_bimbingan;
        }

        if ($request->ajax()){
            $data = RiwayatBimbinganModel::where('bimbingan_kode', $kb)
                ->where('konsultasi_jenis', $jenis)
                ->where('konsultasi_bab', $bab)
                ->get();
            return DataTables::of($data)->addIndexColumn()->toJson();
        }
        return response()->json();
    }
}
