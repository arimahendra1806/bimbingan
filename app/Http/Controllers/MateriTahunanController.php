<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\MateriTahunanModel;
use DataTables;
use Validator, File;

class MateriTahunanController extends Controller
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

        if ($request->ajax()){
            $data = MateriTahunanModel::latest()->get()->load('tahun');
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
        return view('koordinator.kelola-materi-tahun-ajaran.index', compact('tahun_id'));
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
            'tahun_ajaran_id_add' => 'required',
            'file_materi_add' => 'required|file|max:2048|mimes:pdf',
            'keterangan_add' => 'required',
        ]);

        $data = new MateriTahunanModel;
        $data->tahun_ajaran_id = $request->tahun_ajaran_id_add;
        if ($request->hasFile('file_materi_add')){
            $file = $request->file('file_materi_add');
            $filename = time()."_".$file->getClientOriginalName();
            $file->move(public_path('dokumen/materi-tahunan'), $filename);

            $data->file_materi = $filename;
        }
        $data->keterangan = $request->keterangan_add;
        $data->save();

        return response()->json(["success" => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($materi_tahunan)
    {
        $data = MateriTahunanModel::find($materi_tahunan)->load('tahun');
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
    public function update(Request $request, $materi_tahunan)
    {
        $init = $request->file_materi_edit;
        if ($init == "") {
            $request->validate([
                'tahun_ajaran_id_edit' => 'required',
                'keterangan_edit' => 'required',
            ]);
        } else {
            $request->validate([
                'tahun_ajaran_id_edit' => 'required',
                'file_materi_edit' => 'required|file|max:2048|mimes:pdf',
                'keterangan_edit' => 'required',
            ]);
        }

        $data = MateriTahunanModel::where('id', $materi_tahunan)->first();
        $data->tahun_ajaran_id = $request->tahun_ajaran_id_edit;
        if ($request->hasFile('file_materi_edit')){
            $file = $request->file('file_materi_edit');
            $filename = time()."_".$file->getClientOriginalName();
            $file->move(public_path('dokumen/materi-tahunan'), $filename);

            $path = public_path() . '/dokumen/materi-tahunan/' . $data->file_materi;
            File::delete($path);

            $data->file_materi = $filename;
        }
        $data->keterangan = $request->keterangan_edit;
        $data->save();

        return response()->json(["success" => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($materi_tahunan)
    {
        $data = MateriTahunanModel::find($materi_tahunan);

        $path = public_path() . '/dokumen/materi-tahunan/' . $data->file_materi;
        File::delete($path);

        $data->delete();
        return response()->json();
    }
}
