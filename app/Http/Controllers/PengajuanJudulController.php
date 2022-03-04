<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\PengajuanJudulModel;
use DataTables;
use Auth;

class PengajuanJudulController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* Get data Tahun_id */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Get data User Identitas */
        $identitas = Auth::user()->identitas_id;

        /* Get count pengajuan u/ kondisi */
        $count = PengajuanJudulModel::where('nim', $identitas)->count('id');

        if ($request->ajax()){
            $data = PengajuanJudulModel::where('tahun_ajaran_id', $tahun_id->id)->where('nim', $identitas)->get()->load('tahun');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('mahasiswa.pengajuan-judul.index', compact('tahun_id', 'identitas', 'count'));
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
        if($request->pengerjaan_add == "Kelompok"){
            $request->validate([
                'judul_add' => 'required',
                'studi_kasus_add' => 'required',
                'pengerjaan_add' => 'required',
                'nim_anggota_add' => 'required|numeric',
            ]);
        } else {
            $request->validate([
                'judul_add' => 'required',
                'studi_kasus_add' => 'required',
                'pengerjaan_add' => 'required',
            ]);
        }

        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        $data = new PengajuanJudulModel;
        $data->nim = $request->nim_add;
        $data->tahun_ajaran_id = $tahun_id->id;
        $data->judul = $request->judul_add;
        $data->studi_kasus = $request->studi_kasus_add;
        $data->pengerjaan = $request->pengerjaan_add;

        if($request->pengerjaan_add == "Kelompok"){
            $data->nim_anggota = $request->nim_anggota_add;
        } else {
            $data->nim_anggota = "";
        }

        $data->status = "Diproses";
        $data->save();

        return response()->json(["success" => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pengajuan_judul)
    {
        $data = PengajuanJudulModel::find($pengajuan_judul);
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
    public function update(Request $request, $pengajuan_judul)
    {
        if($request->pengerjaan_add == "Kelompok"){
            $request->validate([
                'judul_edit' => 'required',
                'studi_kasus_edit' => 'required',
                'pengerjaan_edit' => 'required',
                'nim_anggota_edit' => 'required|numeric',
            ]);
        } else {
            $request->validate([
                'judul_edit' => 'required',
                'studi_kasus_edit' => 'required',
                'pengerjaan_edit' => 'required',
            ]);
        }

        $data = PengajuanJudulModel::where('id', $pengajuan_judul)->first();
        $data->judul = $request->judul_edit;
        $data->studi_kasus = $request->studi_kasus_edit;
        $data->pengerjaan = $request->pengerjaan_edit;

        if($request->pengerjaan_edit == "Kelompok"){
            $data->nim_anggota = $request->nim_anggota_edit;
        } else {
            $data->nim_anggota = "";
        }
        $data->save();

        return response()->json(["success" => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
