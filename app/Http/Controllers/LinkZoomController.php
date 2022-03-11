<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LinkZoomModel;
use App\Models\TahunAjaran;
use App\Models\DosenModel;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LinkZoomImport;

class LinkZoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* Get data Tahun_id */
        $tahun_id = TahunAjaran::all()->sortByDesc('tahun_ajaran');

        /* Get data Dosen_id */
        $dosen_id = DosenModel::all()->sortBy('nama_dosen');

        if ($request->ajax()){
            $data = LinkZoomModel::latest()->get()->load('tahun');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-info" id="btnShow" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>
                    <a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>
                    <a id="btnDelete" data-id="'.$model->id.'" class="btn btn-danger" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-prescription-bottle"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('koordinator.kelola-link-zoom.index', compact('tahun_id', 'dosen_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nidn_add' => 'required|numeric',
            'tahun_ajaran_id_add' => 'required',
            'id_meeting_add' => 'required',
            'passcode_add' => 'required',
            'link_add' => 'required',
        ]);

        $data = new LinkZoomModel;
        $data->nidn = $request->nidn_add;
        $data->tahun_ajaran_id = $request->tahun_ajaran_id_add;
        $data->id_meeting = $request->id_meeting_add;
        $data->passcode = $request->passcode_add;
        $data->link_zoom = $request->link_add;
        $data->save();

        return response()->json(["success" => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($link_zoom)
    {
        $data = LinkZoomModel::find($link_zoom)->load('tahun');
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $link_zoom)
    {
        $request->validate([
            'nidn_edit' => 'required|numeric',
            'tahun_ajaran_id_edit' => 'required',
            'id_meeting_edit' => 'required',
            'passcode_edit' => 'required',
            'link_edit' => 'required',
        ]);

        $data = LinkZoomModel::where('id', $link_zoom)->first();
        $data->nidn = $request->nidn_edit;
        $data->tahun_ajaran_id = $request->tahun_ajaran_id_edit;
        $data->id_meeting = $request->id_meeting_edit;
        $data->passcode = $request->passcode_edit;
        $data->link_zoom = $request->link_edit;
        $data->save();

        return response()->json(["success" => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($link_zoom)
    {
        $data = LinkZoomModel::find($link_zoom)->delete();
        return response()->json();
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_import' => 'required|mimes:csv,xlsx,xls'
        ]);

        $file = $request->file('file_import');
        Excel::import(new LinkZoomImport, $file);

        return response()->json();
    }
}
