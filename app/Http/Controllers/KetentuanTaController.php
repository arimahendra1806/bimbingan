<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\MateriTahunanModel;
use DataTables;

class KetentuanTaController extends Controller
{
    public function indexMhs(Request $request)
    {
        /* Get data Tahun_id */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

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
        return view('mahasiswa.ketentuan-ta.index', compact('tahun_id'));
    }

    public function downloadMhs($ketentuan_ta){
        $data = MateriTahunanModel::find($ketentuan_ta);
        return response()->json($data);
    }
}
