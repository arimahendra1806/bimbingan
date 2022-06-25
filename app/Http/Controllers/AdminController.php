<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AdminModel;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Imports\AdminImport;
use DataTables, Validator;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* Ambil data tabel admin */
        if ($request->ajax()){
            $data = AdminModel::latest()->get();
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
        return view('koordinator.kelola-admin.index');
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
            'nip_add' => ['required','numeric','unique:admin,nip'],
            'nama_admin_add' => ['required'],
            'alamat_add' => ['required'],
            'email_add' => ['required','email'],
            'no_telepon_add' => ['required','string','numeric','digits_between:10,12','regex:/^[1-9]{1}/']
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'nip_add' => 'NIP',
            'nama_admin_add' => 'Nama Admin',
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
            $pengguna->username = $request->nip_add;
            $pengguna->tahun_ajaran_id = $tahun->id;
            $pengguna->name = $request->nama_admin_add;
            $pengguna->role = "admin";
            $pengguna->password = Hash::make($request->nip_add);
            $pengguna->save();

            /* Insert ke tabel Admin */
            $data = new AdminModel;
            $data->users_id = $pengguna->id;
            $data->nip = $request->nip_add;
            $data->nama_admin = $request->nama_admin_add;
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
    public function show($kelola_admin)
    {
        /* Ambil data Admin sesuai parameter */
        $data = AdminModel::find($kelola_admin);

        /* Return json data Admin */
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
    public function update(Request $request, $kelola_admin)
    {
        /* Ambil data admin sesuai parameter */
        $data = AdminModel::with('user')->where('id', $kelola_admin)->first();

        /* Kondisi data nip tidak sama, maka validasi berikut */
        if($data->nip == $request->nip_edit) {
            /* Peraturan validasi  */
            $rules = [
                'nama_admin_edit' => ['required'],
                'alamat_edit' => ['required'],
                'email_edit' => ['required','email'],
                'no_telepon_edit' => ['required','numeric','digits_between:10,12','regex:/^[1-9]{1}/']
            ];
        } else {
            /* Peraturan validasi  */
            $rules = [
                'nip_edit' => ['required','numeric','unique:admin,nip'],
                'nama_admin_edit' => ['required'],
                'alamat_edit' => ['required'],
                'email_edit' => ['required','email'],
                'no_telepon_edit' => ['required','numeric','digits_between:10,12','regex:/^[1-9]{1}/']
            ];
        }

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'nip_edit' => 'NIP',
            'nama_admin_edit' => 'Nama Admin',
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
                $data->user->username = $request->nip_edit;
                $data->user->name = $request->nama_admin_edit;
                $data->user->password = Hash::make($request->nip_edit);
                $data->user->save();
            }

            /* Update tabel admin */
            $data->nip = $request->nip_edit;
            $data->nama_admin = $request->nama_admin_edit;
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
    public function destroy($kelola_admin)
    {
        /* Ambil data admin sesuai parameter */
        $data = AdminModel::find($kelola_admin);

        /* Hapus data admin */
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
            /* Impor data admin*/
            $file = $request->file('file_import');
            Excel::import(new AdminImport, $file);

            /* Return json berhasil */
            return response()->json(['msg' => "Berhasil Mengimpor Data!"]);
        }
    }

    public function indexKaprodi(Request $request)
    {
        /* Ambil data tabel dosen */
        if ($request->ajax()){
            $data = AdminModel::latest()->get();
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
        return view('kaprodi.data-admin.index');
    }
}
