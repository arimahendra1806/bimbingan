<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\TahunAjaran;
use App\Models\MahasiswaModel;
use App\Models\User;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MahasiswaImport;

class MahasiswaController extends Controller
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
            $data = MahasiswaModel::latest()->get()->load('tahun');
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
        return view('koordinator.kelola-mahasiswa.index', compact('tahun_id'));
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
            'nim_add' => 'required|numeric',
            'tahun_ajaran_id_add' => 'required',
            'nama_mhs_add' => 'required',
            'alamat_add' => 'required',
            'email_add' => 'required',
            'no_telepon_add' => 'required|string|min:10|max:13|regex:/^[1-9]{1}/',
        ]);

        $data = new MahasiswaModel;
        $data->nim = $request->nim_add;
        $data->tahun_ajaran_id = $request->tahun_ajaran_id_add;
        $data->nama_mahasiswa = $request->nama_mhs_add;
        $data->alamat = $request->alamat_add;
        $data->email = $request->email_add;
        $data->no_telepon = $request->no_telepon_add;
        $data->save();

        $pengguna = new User;
        $pengguna->identitas_id = $request->nim_add;
        $pengguna->tahun_ajaran_id = $request->tahun_ajaran_id_add;
        $pengguna->name = $request->nama_mhs_add;
        $pengguna->role = "mahasiswa";
        $pengguna->email = $request->nim_add."@bimbingan.id";
        $pengguna->password = Hash::make($request->nim_add);
        $pengguna->save();

        return response()->json(["success" => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($kelola_mahasiswa)
    {
        $data = MahasiswaModel::find($kelola_mahasiswa)->load('tahun');
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
    public function update(Request $request, $kelola_mahasiswa)
    {
        $request->validate([
            'nim_edit' => 'required|numeric',
            'tahun_ajaran_id_edit' => 'required',
            'nama_mhs_edit' => 'required',
            'alamat_edit' => 'required',
            'email_edit' => 'required',
            'no_telepon_edit' => 'required|string|min:10|max:13|regex:/^[1-9]{1}/',
        ]);

        $data = MahasiswaModel::where('id', $kelola_mahasiswa)->first();

        $pengguna_id = User::where('identitas_id', $data->nim)->first();
        $pengguna = User::where('id', $pengguna_id->id)->first();
        $pengguna->identitas_id = $request->nim_edit;
        $pengguna->name = $request->nama_mhs_edit;
        $pengguna->email = $request->nim_edit."@bimbingan.id";
        $pengguna->password = Hash::make($request->nim_edit);
        $pengguna->save();

        $data->nim = $request->nim_edit;
        $data->tahun_ajaran_id = $request->tahun_ajaran_id_edit;
        $data->nama_mahasiswa = $request->nama_mhs_edit;
        $data->alamat = $request->alamat_edit;
        $data->email = $request->email_edit;
        $data->no_telepon = $request->no_telepon_edit;
        $data->save();

        return response()->json(["success" => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($kelola_mahasiswa)
    {
        $data = MahasiswaModel::find($kelola_mahasiswa);
        User::where('identitas_id', $data->nim)->delete();
        $data->delete();
        return response()->json();
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_import' => 'required|mimes:csv,xlsx,xls'
        ]);

        if ($request->hasFile('file_import')){
            $file = $request->file('file_import');
            $filename = time()."_".$file->getClientOriginalName();
            $import = $file->move(public_path('dokumen/import/mahasiswa'), $filename);
            Excel::import(new MahasiswaImport, $import);
        }
        return response()->json();
    }
}
