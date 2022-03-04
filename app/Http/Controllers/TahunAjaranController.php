<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use DataTables;

class TahunAjaranController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()){
            $data = TahunAjaran::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-info" id="btnShow" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>
                    <a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>
                    <a id="btnDelete" data-id="'.$model->id.'" class="btn btn-danger delete-user" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-prescription-bottle"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('koordinator.kelola-tahun-ajaran.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran_add' => 'required',
            'tahun_status_add' => 'required',
        ]);

        $data = new TahunAjaran;
        $data->tahun_ajaran = $request->tahun_ajaran_add;
        $data->status = $request->tahun_status_add;
        $data->save();

        return response()->json(["success" => true]);
    }

    public function show($tahun_ajaran)
    {
        $data = TahunAjaran::find($tahun_ajaran);
        return response()->json($data);
    }

    public function update(Request $request, $tahun_ajaran)
    {
        $request->validate([
            'tahun_ajaran_edit' => 'required',
            'tahun_status_edit' => 'required',
        ]);

        $data = TahunAjaran::where('id', $tahun_ajaran)->first();
        $data->tahun_ajaran = $request->tahun_ajaran_edit;
        $data->status = $request->tahun_status_edit;
        $data->save();

        return response()->json(["success" => true]);
    }

    public function destroy($tahun_ajaran)
    {
        $data = TahunAjaran::find($tahun_ajaran)->delete();
        return response()->json();
    }
}
