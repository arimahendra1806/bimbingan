<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\DosenModel;
use App\Models\User;
use App\Models\TahunAjaran;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DosenImport;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $data = DosenModel::latest()->get();
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
        return view('koordinator.kelola-dosen.index');
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
            'nama_dosen_add' => 'required',
            'alamat_add' => 'required',
            'email_add' => 'required',
            'no_telepon_add' => 'required|string|min:10|max:13|regex:/^[1-9]{1}/',
        ]);

        $data = new DosenModel;
        $data->nidn = $request->nidn_add;
        $data->nama_dosen = $request->nama_dosen_add;
        $data->alamat = $request->alamat_add;
        $data->email = $request->email_add;
        $data->no_telepon = $request->no_telepon_add;
        $data->save();

        $tahun = TahunAjaran::where('status', 'Aktif')->first();

        $pengguna = new User;
        $pengguna->identitas_id = $request->nidn_add;
        $pengguna->tahun_ajaran_id = $tahun->id;
        $pengguna->name = $request->nama_dosen_add;
        $pengguna->role = "dosen";
        $pengguna->email = $request->nidn_add."@bimbingan.id";
        $pengguna->password = Hash::make($request->nidn_add);
        $pengguna->save();

        return response()->json(["success" => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($kelola_dosen)
    {
        $data = DosenModel::find($kelola_dosen);
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
    public function update(Request $request, $kelola_dosen)
    {
        $request->validate([
            'nidn_edit' => 'required|numeric',
            'nama_dosen_edit' => 'required',
            'alamat_edit' => 'required',
            'email_edit' => 'required',
            'no_telepon_edit' => 'required|string|min:10|max:13|regex:/^[1-9]{1}/',
        ]);

        $data = DosenModel::where('id', $kelola_dosen)->first();

        $pengguna_id = User::where('identitas_id', $data->nidn)->first();
        $pengguna = User::where('id', $pengguna_id->id)->first();
        $pengguna->identitas_id = $request->nidn_edit;
        $pengguna->name = $request->nama_dosen_edit;
        $pengguna->email = $request->nidn_edit."@bimbingan.id";
        $pengguna->password = Hash::make($request->nidn_edit);
        $pengguna->save();

        $data->nidn = $request->nidn_edit;
        $data->nama_dosen = $request->nama_dosen_edit;
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
    public function destroy($kelola_dosen)
    {
        $data = DosenModel::find($kelola_dosen);
        User::where('identitas_id', $data->nidn)->delete();
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
            $import = $file->move(public_path('dokumen/import/dosen'), $filename);
            Excel::import(new DosenImport, $import);
        }
        return response()->json();
    }
}
