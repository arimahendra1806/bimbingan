<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\TahunAjaran;
use App\Models\MahasiswaModel;
use App\Models\User;
use App\Imports\MahasiswaImport;
use App\Models\InformasiModel;
use App\Models\NotifikasiModel;
use DataTables, Validator;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data tabel mahasiswa */
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

        /* Return menuju view */
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
        /* Peraturan validasi  */
        $rules = [
            'nim_add' => ['required','numeric','unique:mahasiswa,nim'],
            'tahun_ajaran_id_add' => ['required'],
            'nama_mhs_add' => ['required'],
            'alamat_add' => ['required'],
            'email_add' => ['required','email'],
            'no_telepon_add' => ['required','numeric','digits_between:10,12','regex:/^[1-9]{1}/']
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'nim_add' => 'NIM',
            'tahun_ajaran_id_add' => 'ID Tahun Ajaran',
            'nama_mhs_add' => 'Nama Mahasiswa',
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
            $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

            /* Insert ke tabel User */
            $pengguna = new User;
            $pengguna->username = $request->nim_add;
            $pengguna->tahun_ajaran_id = $tahun_id->id;
            $pengguna->name = $request->nama_mhs_add;
            $pengguna->role = "mahasiswa";
            $pengguna->password = Hash::make($request->nim_add);
            $pengguna->save();

            /* Insert ke tabel mahasiswa */
            $data = new MahasiswaModel;
            $data->users_id = $pengguna->id;
            $data->nim = $request->nim_add;
            $data->tahun_ajaran_id = $tahun_id->id;
            $data->nama_mahasiswa = $request->nama_mhs_add;
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
    public function show($kelola_mahasiswa)
    {
        /* Ambil data Mahasiswa sesuai parameter */
        $data = MahasiswaModel::find($kelola_mahasiswa)->load('tahun');

        /* Return json data Mahasiswa */
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
        /* Ambil data mahasiswa sesuai parameter */
        $data = MahasiswaModel::with('user')->where('id', $kelola_mahasiswa)->first();

        /* Kondisi data nim tidak sama, maka validasi berikut */
        if($data->nim == $request->nim_edit) {
            /* Peraturan validasi  */
            $rules = [
                'tahun_ajaran_id_edit' => ['required'],
                'nama_mhs_edit' => ['required'],
                'alamat_edit' => ['required'],
                'email_edit' => ['required','email'],
                'no_telepon_edit' => ['required','numeric','digits_between:10,12','regex:/^[1-9]{1}/']
            ];
        } else {
            /* Peraturan validasi  */
            $rules = [
                'nim_edit' => ['required','numeric','unique:mahasiswa,nim'],
                'tahun_ajaran_id_edit' => ['required'],
                'nama_mhs_edit' => ['required'],
                'alamat_edit' => ['required'],
                'email_edit' => ['required','email'],
                'no_telepon_edit' => ['required','numeric','digits_between:10,12','regex:/^[1-9]{1}/']
            ];
        }

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'nim_edit' => 'NIM',
            'tahun_ajaran_id_edit' => 'ID Tahun Ajaran',
            'nama_mhs_edit' => 'Nama Mahasiswa',
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
                $data->user->username = $request->nim_edit;
                $data->user->name = $request->nama_mhs_edit;
                $data->user->password = Hash::make($request->nim_edit);
                $data->user->save();
            }

            /* Update tabel mahasiswa */
            $data->nim = $request->nim_edit;
            $data->nama_mahasiswa = $request->nama_mhs_edit;
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
    public function destroy($kelola_mahasiswa)
    {
        /* Ambil data mahasiswa sesuai parameter */
        $data = MahasiswaModel::find($kelola_mahasiswa);

        /* Hapus data mahasiswa */
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
            /* Impor data mahasiswa*/
            $file = $request->file('file_import');
            Excel::import(new MahasiswaImport, $file);

            /* Return json berhasil */
            return response()->json(['msg' => "Berhasil Mengimpor Data!"]);
        }
    }

    public function indexKaprodi(Request $request)
    {
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data tabel mahasiswa */
        if ($request->ajax()){
            $data = MahasiswaModel::where('tahun_ajaran_id', $tahun_id->id)->latest()->get()->load('tahun');
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
        return view('kaprodi.data-mahasiswa.index');
    }
}
