<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\MateriTahunanModel;
use DataTables;

class KetentuanTaController extends Controller
{
    public function index(Request $request)
    {
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data tabel ketentuan_ta */
        if ($request->ajax()){
            $data = MateriTahunanModel::where('tahun_ajaran_id', $tahun_id->id)->get()->load('tahun');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-info" id="btnDownload" data-toggle="tooltip" title="Download Ketentuan" data-id="'.$model->id.'" href="/dokumen/materi-tahunan/'.$model->file_materi.'" download><i class="fas fa-download"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        /* Return menuju view */
        return view('partial.ketentuan-ta.index');
    }
}
