<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\MateriTahunanModel;
use App\Models\FileMateriTahunanModel;
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
                    $btn = '<a class="btn btn-info" id="btnShow" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>';
                    return $btn;
                })
                ->addColumn('jml_file', function($model){
                    $data = FileMateriTahunanModel::where('ketentuan_ta_id', $model->id)->count('id');
                    return $data;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        /* Return menuju view */
        return view('partial.ketentuan-ta.index');
    }

    public function show($id)
    {
        /* Ambil data materi tahunan sesuai parameter */
        $data = MateriTahunanModel::find($id)->load('tahun');

        /* Return json data materi tahunan */
        return response()->json($data);
    }

    public function tShow(Request $request, $id) {
        if ($request->ajax()){
            $data = FileMateriTahunanModel::where('ketentuan_ta_id', $id)->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-secondary" id="tBtnDownload" data-toggle="tooltip" title="Download File" data-id="'.$model->id.'" href="/dokumen/materi-tahunan/'.$model->nama_file.'" download><i class="fas fa-download"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
    }
}
