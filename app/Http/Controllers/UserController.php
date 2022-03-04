<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\TahunAjaran;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use DataTables;

class UserController extends Controller
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

        /* Get data Mahasiswa_id */
        $mhs_id = MahasiswaModel::all()->sortByDesc('nama_mahasiswa');

        if ($request->ajax()){
            $data = User::latest()->get()->load('tahun');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-info" id="btnShow" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>
                    <a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>
                    <a id="btnDelete" data-id="'.$model->id.'" class="btn btn-danger" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-prescription-bottle"></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('koordinator.kelola-pengguna.index', compact('tahun_id', 'dosen_id', 'mhs_id'));
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
            'identitas_id_add' => 'required|numeric',
            'tahun_ajaran_id_add' => 'required',
            'nama_pengguna_add' => 'required',
            'role_pengguna_add' => 'required',
            'email_pengguna_add' => 'required',
            'password_pengguna_add' => 'required|min:8',
        ]);

        $data = new User;
        $data->identitas_id = $request->identitas_id_add;
        $data->tahun_ajaran_id = $request->tahun_ajaran_id_add;
        $data->name = $request->nama_pengguna_add;
        $data->role = $request->role_pengguna_add;
        $data->email = $request->email_pengguna_add;
        $data->password = Hash::make($request->password_pengguna_add);
        $data->save();

        return response()->json(["success" => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pengguna)
    {
        $data = User::find($pengguna)->load('tahun');
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
    public function update(Request $request, $pengguna)
    {
        if ($request->filled('password_pengguna_edit')) {
            $request->validate([
                'identitas_id_edit' => 'required|numeric',
                'tahun_ajaran_id_edit' => 'required',
                'nama_pengguna_edit' => 'required',
                'role_pengguna_edit' => 'required',
                'email_pengguna_edit' => 'required',
                'password_pengguna_edit' => 'required|min:8',
            ]);
        } else {
            $request->validate([
                'identitas_id_edit' => 'required|numeric',
                'tahun_ajaran_id_edit' => 'required',
                'nama_pengguna_edit' => 'required',
                'role_pengguna_edit' => 'required',
                'email_pengguna_edit' => 'required',
            ]);
        }

        $data = User::where('id', $pengguna)->first();
        $data->identitas_id = $request->identitas_id_edit;
        $data->tahun_ajaran_id = $request->tahun_ajaran_id_edit;
        $data->name = $request->nama_pengguna_edit;
        $data->role = $request->role_pengguna_edit;
        $data->email = $request->email_pengguna_edit;
        if ($request->filled('password_pengguna_edit')){
            $data->password = Hash::make($request->password_pengguna_edit);
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
    public function destroy($pengguna)
    {
        $data = User::find($pengguna)->delete();
        return response()->json();
    }

}
