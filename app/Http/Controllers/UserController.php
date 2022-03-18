<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\TahunAjaran;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use DataTables, Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::all()->sortByDesc('tahun_ajaran');

        /* Ambil data dosen */
        $dosen_id = DosenModel::all()->sortBy('nama_dosen');

        /* Ambil data mahasiswa */
        $mhs_id = MahasiswaModel::all()->sortBy('nama_mahasiswa');

        /* Ambil data tabel user */
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

        /* Return menuju view */
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
        /* Peraturan validasi  */
        $rules = [
            'username_add' => ['required','numeric','unique:users,username'],
            'tahun_ajaran_id_add' => ['required'],
            'nama_pengguna_add' => ['required'],
            'role_pengguna_add' => ['required'],
            'password_pengguna_add' => ['required','min:8']
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'username_add' => 'Username',
            'tahun_ajaran_id_add' => 'ID Tahun Ajaran',
            'nama_pengguna_add' => 'Nama Pengguna',
            'role_pengguna_add' => 'Role Pengguna',
            'password_pengguna_add' => 'Password'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Insert ke tabel User */
            $data = new User;
            $data->username = $request->username_add;
            $data->tahun_ajaran_id = $request->tahun_ajaran_id_add;
            $data->name = $request->nama_pengguna_add;
            $data->role = $request->role_pengguna_add;
            $data->password = Hash::make($request->password_pengguna_add);
            $data->save();

            /* Ambil data dosen sesuai parameter */
            $dsn = DosenModel::where('nidn', $data->username)->first();
            /* Kondisi jika data dosen kosong */
            if($dsn){
                /* Update data dosen */
                $dsn->users_id = $data->id;
                $dsn->save();
            } else {
                /* Ambil data dosen sesuai parameter */
                $mhs = MahasiswaModel::where('nim', $data->username)->first();
                if($mhs){
                    /* Update data mahasiswa */
                    $mhs->users_id = $data->id;
                    $mhs->save();
                }
            }

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Menambahkan Data!"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pengguna)
    {
        /* Ambil data Users sesuai parameter */
        $data = User::find($pengguna)->load('tahun');

        /* Return json data Users */
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
        /* Ambil data users sesuai parameter */
        $data = User::where('id', $pengguna)->first();

        /* Kondisi data username tidak sama, maka validasi berikut */
        if($data->username == $request->username_edit) {
            if($request->filled('password_pengguna_edit')) {
                /* Peraturan validasi  */
                $rules = [
                    'tahun_ajaran_id_edit' => ['required'],
                    'nama_pengguna_edit' => ['required'],
                    'role_pengguna_edit' => ['required'],
                    'password_pengguna_edit' => ['required','min:8']
                ];
            } else {
                /* Peraturan validasi  */
                $rules = [
                    'tahun_ajaran_id_edit' => ['required'],
                    'nama_pengguna_edit' => ['required'],
                    'role_pengguna_edit' => ['required'],
                ];
            }
        } else {
            if ($request->filled('password_pengguna_edit')) {
                /* Peraturan validasi  */
                $rules = [
                    'username_edit' => ['required','numeric','unique:users,username'],
                    'tahun_ajaran_id_edit' => ['required'],
                    'nama_pengguna_edit' => ['required'],
                    'role_pengguna_edit' => ['required'],
                    'password_pengguna_edit' => ['required','min:8']
                ];
            } else {
                /* Peraturan validasi  */
                $rules = [
                    'username_edit' => ['required','numeric','unique:users,username'],
                    'tahun_ajaran_id_edit' => ['required'],
                    'nama_pengguna_edit' => ['required'],
                    'role_pengguna_edit' => ['required'],
                ];
            }
        }

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'username_edit' => 'Username',
            'tahun_ajaran_id_edit' => 'ID Tahun Ajaran',
            'nama_pengguna_edit' => 'Nama Pengguna',
            'role_pengguna_edit' => 'Role Pengguna',
            'password_pengguna_edit' => 'Password'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Update tabel user */
            $data->username = $request->username_edit;
            $data->tahun_ajaran_id = $request->tahun_ajaran_id_edit;
            $data->name = $request->nama_pengguna_edit;
            $data->role = $request->role_pengguna_edit;
            if ($request->filled('password_pengguna_edit')){
                $data->password = Hash::make($request->password_pengguna_edit);
            }
            $data->save();

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Memperbarui Data!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($pengguna)
    {
        /* Ambil data users sesuai parameter */
        $data = User::find($pengguna);

        /* Kondisi jika data dosen ada maka update users_id */
        if($data->dosen){
            $data->dosen->users_id = rand(10,99) . rand(100,999);
            $data->dosen->save();
        }

        /* Kondisi jika data mahasiswa ada maka update users_id */
        if($data->mahasiswa){
            $data->mahasiswa->users_id = rand(10,99) . rand(100,999);
            $data->mahasiswa->save();
        }

        /* Hapus data users */
        $data->forceDelete();

        /* Return json berhasil */
        return response()->json(['msg' => "Berhasil Menghapus Data!"]);
    }

}
