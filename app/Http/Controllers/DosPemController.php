<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\DosPemModel;
use App\Models\PengajuanJudulModel;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use DataTables;

class DosPemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* Get data Tahun */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Get data Dosen_id */
        $dosen_id = DosenModel::all()->sortBy('nama_dosen');

        /* Get data Mhs_id */
        $mhs_id = MahasiswaModel::all()->sortBy('nama_mahasiswa');

        if ($request->ajax()){
            $data = DosPemModel::where('tahun_ajaran_id', $tahun_id->id)->get()->load('tahun');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>
                    <a id="btnDelete" data-id="'.$model->id.'" class="btn btn-danger" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-prescription-bottle"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('koordinator.kelola-dosen-pembimbing.index', compact('tahun_id', 'dosen_id', 'mhs_id'));
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
            'nidn_add'  => 'required|numeric',
            'nim_add.*'  => 'required|numeric',
        ]);

        $pembimbing = substr($request->nidn_add, -4);
        $nidn = $request->nidn_add;
        $nim = $request->nim_add;
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();
        for($count = 0; $count < count($nim); $count++)
        {
            $data = new DosPemModel;
            $data->kode_pembimbing = "KP".$pembimbing.substr($nim[$count], -4);
            $data->nidn = $nidn;
            $data->nim = $nim[$count];
            $data->tahun_ajaran_id = $tahun_id->id;
            $data->save();

            PengajuanJudulModel::where('nim', $nim[$count])->update(['status' => "Mendapat Pembimbing"]);
        }

        return response()->json(["success" => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($dosen_pembimbing)
    {
        $data = DosPemModel::find($dosen_pembimbing)->load('tahun');
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
    public function update(Request $request, $dosen_pembimbing)
    {
        $request->validate([
            'nidn_edit'  => 'required|numeric',
            'nim_edit'  => 'required|numeric',
        ]);

        $data = DosPemModel::where('id', $dosen_pembimbing)->first();
        $data->kode_pembimbing = "KP".substr($request->nidn_edit, -4).substr($request->nim_edit, -4);
        $data->nidn = $request->nidn_edit;
        $data->nim = $request->nim_edit;
        $data->save();

        return response()->json(["success" => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($dosen_pembimbing)
    {
        $dospem = DosPemModel::find($dosen_pembimbing);
        PengajuanJudulModel::where('nim', $dospem->nim)->update(['status' => "Diproses"]);
        $dospem->delete();
        return response()->json();
    }

    public function judul(Request $request){
        /* Get data Tahun_id */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        if ($request->ajax()){
            $data = PengajuanJudulModel::where('tahun_ajaran_id', $tahun_id->id)->get();
            return DataTables::of($data)->toJson();
        }
        return response()->json();
    }

    public function jumlahNidn($nidn)
    {
        /* Get data Tahun_id */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        $countNidn = DosPemModel::where('nidn', $nidn)->where('tahun_ajaran_id', $tahun_id->id)->count('id');
        return response()->json(['data' => $countNidn]);
    }
}
