<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DosenModel;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Models\LinkZoomModel;
use App\Models\InformasiModel;
use App\Models\NotifikasiModel;
use App\Imports\DosenImport;
use DataTables, Validator;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* Ambil data tabel dosen */
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

        /* Return menuju view */
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
        /* Peraturan validasi  */
        $rules = [
            'nidn_add' => ['required','numeric','unique:dosen,nidn'],
            'nama_dosen_add' => ['required'],
            'alamat_add' => ['required'],
            'email_add' => ['required','email'],
            'no_telepon_add' => ['required','numeric','digits_between:10,12','regex:/^[1-9]{1}/']
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'nidn_add' => 'NIDN',
            'nama_dosen_add' => 'Nama Dosen',
            'alamat_add' => 'Alamat',
            'email_add' => 'Email',
            'no_telepon_add' => 'Nomor Telepon'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Ambil data tahun_ajaran */
            $tahun = TahunAjaran::where('status', 'Aktif')->first();

            /* Insert ke tabel User */
            $pengguna = new User;
            $pengguna->username = $request->nidn_add;
            $pengguna->tahun_ajaran_id = $tahun->id;
            $pengguna->name = $request->nama_dosen_add;
            $pengguna->role = "dosen";
            $pengguna->password = Hash::make($request->nidn_add);
            $pengguna->save();

            /* Insert ke tabel Dosen */
            $data = new DosenModel;
            $data->users_id = $pengguna->id;
            $data->nidn = $request->nidn_add;
            $data->nama_dosen = $request->nama_dosen_add;
            $data->alamat = $request->alamat_add;
            $data->email = $request->email_add;
            $data->no_telepon = $request->no_telepon_add;
            $data->save();

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
    public function show($kelola_dosen)
    {
        /* Ambil data Dosen sesuai parameter */
        $data = DosenModel::find($kelola_dosen);

        /* Return json data Dosen */
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
        /* Ambil data dosen sesuai parameter */
        $data = DosenModel::with('user')->where('id', $kelola_dosen)->first();

        /* Kondisi data nidn tidak sama, maka validasi berikut */
        if($data->nidn == $request->nidn_edit) {
            /* Peraturan validasi  */
            $rules = [
                'nama_dosen_edit' => ['required'],
                'alamat_edit' => ['required'],
                'email_edit' => ['required','email'],
                'no_telepon_edit' => ['required','numeric','digits_between:10,12','regex:/^[1-9]{1}/']
            ];
        } else {
            /* Peraturan validasi  */
            $rules = [
                'nidn_edit' => ['required','numeric','unique:dosen,nidn'],
                'nama_dosen_edit' => ['required'],
                'alamat_edit' => ['required'],
                'email_edit' => ['required','email'],
                'no_telepon_edit' => ['required','numeric','digits_between:10,12','regex:/^[1-9]{1}/']
            ];
        }

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'nidn_edit' => 'NIDN',
            'nama_dosen_edit' => 'Nama Dosen',
            'alamat_edit' => 'Alamat',
            'email_edit' => 'Email',
            'no_telepon_edit' => 'Nomor Telepon'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Update tabel user */
            if ($data->user)
            {
                $data->user->username = $request->nidn_edit;
                $data->user->name = $request->nama_dosen_edit;
                $data->user->password = Hash::make($request->nidn_edit);
                $data->user->save();
            }

            /* Update tabel dosen */
            $data->nidn = $request->nidn_edit;
            $data->nama_dosen = $request->nama_dosen_edit;
            $data->alamat = $request->alamat_edit;
            $data->email = $request->email_edit;
            $data->no_telepon = $request->no_telepon_edit;
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
    public function destroy($kelola_dosen)
    {
        /* Ambil data dosen sesuai parameter */
        $data = DosenModel::find($kelola_dosen);

        /* Hapus data dosen */
        $data->forceDelete();

        /* Return json berhasil */
        return response()->json(['msg' => "Berhasil Menghapus Data!"]);
    }

    public function import(Request $request)
    {
        /* Peraturan validasi  */
        $rules = [
            'file_import' => ['required','file','max:2048','mimes:csv,xlsx,xls']
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'file_import' => 'File Data Import'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Impor data dosen*/
            $file = $request->file('file_import');
            Excel::import(new DosenImport, $file);

            /* Return json berhasil */
            return response()->json(['msg' => "Berhasil Mengimpor Data!"]);
        }
    }

    public function indexKaprodi(Request $request)
    {
        /* Ambil data tabel dosen */
        if ($request->ajax()){
            $data = DosenModel::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-info" id="btnShow" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        /* Return menuju view */
        return view('kaprodi.data-dosen.index');
    }
}
