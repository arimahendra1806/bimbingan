<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\InformasiModel;
use App\Models\NotifikasiModel;
use App\Models\User;
use App\Models\TahunAjaran;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use App\Models\DosPemModel;
use App\Mail\MailController;
use DataTables, Validator, Auth, File;

class PeringatanController extends Controller
{
    private function addNotif($array, $data_id){
        // $email = InformasiModel::find($data_id);

        /* Perulangan insert data notifikasi sesuai parameter && notifikasi email */
        foreach ($array as $key => $value) {
            // $penerima = User::with('dosen','mahasiswa')->find($value);

            // $subjek = $email->subyek;
            // $details = [
            //     'title' => $email->jenis . " - " . $email->judul,
            //     'body' => $email->pesan
            // ];

            // if ($penerima->dosen){
            //     Mail::to($penerima->dosen->email)->send(new \App\Mail\MailController($details, $subjek));
            // } elseif ($penerima->mahasiswa){
            //     Mail::to($penerima->mahasiswa->email)->send(new \App\Mail\MailController($details, $subjek));
            // }

            $data2 = new NotifikasiModel;
            $data2->informasi_id = $data_id;
            $data2->kepada = $value;
            $data2->jenis = "Peringatan";
            $data2->status = "Belum Dibaca";
            $data2->save();
        }
    }

    private function kondisiNotif($kepada_role, $kepada_id, $data_info_role, $data_info_id){
        /* Ambil data user login */
        $user_id = Auth::user()->id;
        $user_role = Auth::user()->role;

        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data user role */
        $arr_koor = User::where('role', "koordinator")->pluck('id')->toArray();
        $arr_dsn = User::where('role', "dosen")->pluck('id')->toArray();
        $arr_mhs = User::where('role', "mahasiswa")->pluck('id')->toArray();

        /* Kondisi jika role kepada */
        if ($kepada_role == "semua pengguna"){
            /* Kondisi jika user akses role sesuai */
            if ($user_role == "koordinator") {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($arr_dsn, $data_info_id);
                $this->addNotif($arr_mhs, $data_info_id);
            } elseif ($user_role == "kaprodi") {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($arr_koor, $data_info_id);
                $this->addNotif($arr_dsn, $data_info_id);
                $this->addNotif($arr_mhs, $data_info_id);
            }
        } elseif($kepada_role == "koordinator dosen"){
            /* Jalankan function addNotif sesuai dengan parameter */
            $this->addNotif($arr_koor, $data_info_id);
            $this->addNotif($arr_dsn, $data_info_id);
        } elseif($kepada_role == "dosen mahasiswa"){
            /* Jalankan function addNotif sesuai dengan parameter */
            $this->addNotif($arr_dsn, $data_info_id);
            $this->addNotif($arr_mhs, $data_info_id);
        } elseif ($kepada_role == "koordinator"){
            /* Kondisi jika kepada sama dengan 0 */
            if ($kepada_id == "0") {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($arr_koor, $data_info_id);
            } else {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($data_info_role, $data_info_id);
            }
        } elseif ($kepada_role == "dosen"){
            /* Kondisi jika kepada sama dengan 0 */
            if ($kepada_id == "0") {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($arr_dsn, $data_info_id);
            } else {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($data_info_role, $data_info_id);
            }
        } elseif ($kepada_role == "mahasiswa"){
            /* Kondisi jika kepada sama dengan 0 */
            if ($kepada_id == "0") {
                /* Kondisi jika user akses role sesuai */
                if ($user_role == "dosen"){
                    /* Inisiasi variabel untuk mendapatkan array id mhs sesuai id dosen */
                    $dsn_id = DosenModel::where('users_id', $user_id)->first();
                    $dospem = DosPemModel::where('dosen_id', $dsn_id->id)
                        ->where('tahun_ajaran_id', $tahun_id->id)->get();
                    $arr_mhs_id = $dospem->pluck('mahasiswa_id')->toArray();
                    $mhs = MahasiswaModel::whereIn('id', $arr_mhs_id)->get();
                    $arr_mhs_user_id = $mhs->pluck('users_id')->toArray();
                    /* Jalankan function addNotif sesuai dengan parameter */
                    $this->addNotif($arr_mhs_user_id, $data_info_id);
                } else {
                    /* Jalankan function addNotif sesuai dengan parameter */
                    $this->addNotif($arr_mhs, $data_info_id);
                }
            } else {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($data_info_role, $data_info_id);
            }
        }
    }

    public function index(Request $request)
    {
        /* Ambil data user login */
        $user_id = Auth::user()->id;

        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data tabel tahun ajaran */
        if ($request->ajax()){
            $data = InformasiModel::latest()->where('jenis', 'Peringatan')
                ->where('users_id', $user_id)->get()->load('tahun');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kepadaDetail', function($model){
                    $kepada = User::where('id', $model->kepada)->first();
                    if($kepada){
                        return $kepada->name;
                    } else {
                        if($model->kepada == "0"){
                            $msg = "Semua";
                            return $msg;
                        } else {
                            return $model->kepada;
                        }
                    }
                })
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-info" id="btnShow" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>
                    <a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>
                    <a id="btnDelete" data-id="'.$model->id.'" class="btn btn-danger delete-user" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-prescription-bottle"></i></a>';
                    return $btn;
                })
                ->rawColumns(['kepadaDetail','action'])
                ->toJson();
        }

        /* Return menuju view */
        return view('partial.kelola-peringatan.index', compact('tahun_id'));
    }

    public function store(Request $request)
    {
        /* Ambil data request file materi */
        $init = $request->file_upload_add;

        if(!$init){
            /* Peraturan validasi  */
            $rules = [
                'tahun_ajaran_add' => ['required'],
                'jenis_add' => ['required'],
                'kepada_role_add' => ['required'],
                'kepada_add' => ['required'],
                'judul_add' => ['required','max:20'],
                'subyek_add' => ['required','max:30'],
                'pesan_add' => ['required']
            ];
        } else {
            /* Peraturan validasi  */
            $rules = [
                'tahun_ajaran_add' => ['required'],
                'jenis_add' => ['required'],
                'kepada_role_add' => ['required'],
                'kepada_add' => ['required'],
                'judul_add' => ['required','max:20'],
                'subyek_add' => ['required','max:30'],
                'pesan_add' => ['required'],
                'file_upload_add' => ['required','file','max:2048','mimes:pdf']
            ];
        }

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'tahun_ajaran_add' => 'Tahun Ajaran',
            'jenis_add' => 'Jenis Informasi',
            'kepada_role_add' => 'Ditujukan Untuk',
            'kepada_add' => 'Kepada',
            'judul_add' => 'Judul Peringatan',
            'subyek_add' => 'Subyek Peringatan',
            'pesan_add' => 'Pesan Peringatan',
            'file_upload_add' => 'Lampiran File'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Ambil data user login */
            $user_id = Auth::user()->id;
            $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

            /* Insert data informasi */
            $data = new InformasiModel;
            $data->users_id = $user_id;
            $data->tahun_ajaran_id = $tahun_id->id;
            $data->kepada_role = $request->kepada_role_add;
            $data->kepada = $request->kepada_add;
            $data->judul = $request->judul_add;
            $data->subyek = $request->subyek_add;
            $data->pesan = $request->pesan_add;
            $data->jenis = "Peringatan";

            /* Jika request terdapat file */
            if ($request->hasFile('file_upload_add')){
                $file = $request->file('file_upload_add');
                $filename = time()."_".$file->getClientOriginalName();
                $file->move(public_path('dokumen/peringatan'), $filename);

                $data->file_upload = $filename;
            }

            $data->save();

            /* Inisiasi variabel setelah insert */
            $data_info_id = $data->id;
            $data_info_role = [$data->kepada];

            /* Jalankan function kondisiNotif sesuai dengan parameter */
            $this->kondisiNotif($request->kepada_role_add, $request->kepada_add, $data_info_role, $data_info_id);

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Menambahkan Data!"]);
        }
    }

    public function show($peringatan)
    {
        /* Ambil data informasi sesuai parameter */
        $data = InformasiModel::with(['penerima' => function($q){
            $q->select('id', 'name');
        }])->find($peringatan)->load('tahun');

        /* Return json data informasi */
        return response()->json($data);
    }

    public function update(Request $request, $peringatan)
    {
        /* Ambil data request file materi */
        $init = $request->file_upload_edit;

        if(!$init){
            /* Peraturan validasi  */
            $rules = [
                'tahun_ajaran_edit' => ['required'],
                'jenis_edit' => ['required'],
                'kepada_role_edit' => ['required'],
                'kepada_edit' => ['required'],
                'judul_edit' => ['required','max:20'],
                'subyek_edit' => ['required','max:30'],
                'pesan_edit' => ['required']
            ];
        } else {
            /* Peraturan validasi  */
            $rules = [
                'tahun_ajaran_edit' => ['required'],
                'jenis_edit' => ['required'],
                'kepada_role_edit' => ['required'],
                'kepada_edit' => ['required'],
                'judul_edit' => ['required','max:20'],
                'subyek_edit' => ['required','max:30'],
                'pesan_edit' => ['required'],
                'file_upload_edit' => ['required','file','max:2048','mimes:pdf']
            ];
        }

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'tahun_ajaran_edit' => 'Tahun Ajaran',
            'jenis_edit' => 'Jenis Informasi',
            'kepada_role_edit' => 'Ditujukan Untuk',
            'kepada_edit' => 'Kepada',
            'judul_edit' => 'Judul Peringatan',
            'subyek_edit' => 'Subyek Peringatan',
            'pesan_edit' => 'Pesan Peringatan',
            'file_upload_edit' => 'Lampiran File'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Ambil data user login */
            $user_id = Auth::user()->id;

            /* Ambil data infomasi sesuai parameter */
            $data = InformasiModel::where('id', $peringatan)->first();

            /* Hapus data notifikasi sesuai dengan parameter */
            $notif = NotifikasiModel::where('informasi_id', $data->id)
                ->where('jenis', 'Peringatan')->forceDelete();

            /* Update peringatan */
            $data->users_id = $user_id;
            $data->kepada_role = $request->kepada_role_edit;
            $data->kepada = $request->kepada_edit;
            $data->judul = $request->judul_edit;
            $data->subyek = $request->subyek_edit;
            $data->pesan = $request->pesan_edit;
            $data->jenis = "Peringatan";

            /* Jika request terdapat file */
            if ($request->hasFile('file_upload_edit')){
                $file = $request->file('file_upload_edit');
                $filename = time()."_".$file->getClientOriginalName();
                $file->move(public_path('dokumen/peringatan'), $filename);

                /* Hapus data file sebelumnya */
                $path = public_path() . '/dokumen/peringatan/' . $data->file_upload;
                File::delete($path);

                $data->file_upload = $filename;
            }

            $data->save();

            /* Inisiasi variabel setelah insert */
            $data_info_id = $data->id;
            $data_info_role = [$data->kepada];

            /* Jalankan function addNotif sesuai dengan parameter */
            $this->kondisiNotif($request->kepada_role_edit, $request->kepada_edit, $data_info_role, $data_info_id);

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Memperbarui Data!"]);
        }
    }

    public function destroy($peringatan)
    {
        /* Hapus data informasi sesuai parameter */
        $data = InformasiModel::find($peringatan);

        /* Hapus data file public */
        $path = public_path() . '/dokumen/peringatan/' . $data->file_upload;
        File::delete($path);

        /* Hapus data informasi */
        $data->forceDelete();

        /* Return json berhasil */
        return response()->json(['msg' => "Berhasil Menghapus Data!"]);
    }

    public function kepada($peringatan){
        /* Ambil data user login */
        $user_id = Auth::user()->id;
        $user_role = Auth::user()->role;

        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Kondisi jika peringatan sesuai role */
        if ($peringatan == "koordinator"){
            /* Inisiasi variabel data sesuai parameter kondisi */
            $data = User::where('role', "koordinator")->select('id', 'name')->orderBy('name')->get();
        } elseif ($peringatan == "dosen"){
            /* Inisiasi variabel data sesuai parameter kondisi */
            $data = User::where('role', "dosen")->select('id', 'name')->orderBy('name')->get();
        } elseif ($peringatan == "mahasiswa") {
            /* Kondisi jika auth role user sesuai dengan role */
            if ($user_role == "dosen"){
                /* Inisiasi variabel untuk mendapatkan array id mhs sesuai id dosen */
                $dsn_id = DosenModel::where('users_id', $user_id)->first();
                $dospem = DosPemModel::where('dosen_id', $dsn_id->id)
                    ->where('tahun_ajaran_id', $tahun_id->id)->get();
                $arr_mhs_id = $dospem->pluck('mahasiswa_id')->toArray();
                $mhs = MahasiswaModel::whereIn('id', $arr_mhs_id)->get();
                $arr_mhs_user_id = $mhs->pluck('users_id')->toArray();

                /* Inisiasi variabel data sesuai parameter kondisi */
                $data = User::where('role', "mahasiswa")
                    ->where('tahun_ajaran_id', $tahun_id->id)
                    ->whereIn('id', $arr_mhs_user_id)->select('id', 'name')
                    ->orderBy('name')
                    ->get();
            } else {
                /* Inisiasi variabel data sesuai parameter kondisi */
                $data = User::where('role', "mahasiswa")
                    ->where('tahun_ajaran_id', $tahun_id->id)->select('id', 'name')
                    ->orderBy('name')
                    ->get();
            }
        }

        /* Return json data user */
        return response()->json($data);
    }

    public function roleInfo(Request $request)
    {
        /* Ambil data user login */
        $user_id = Auth::user()->id;

        /* Ambil data tabel notifikasi */
        if ($request->ajax()){
            $data = NotifikasiModel::with(['informasi' => function($q){
                $q->where('jenis', 'Peringatan');
            },'informasi.tahun' => function($q){
                $q->select('id','tahun_ajaran');
            },'informasi.pengirim' => function($q){
                $q->select('id','name','role');
            }])->latest()->where('kepada', $user_id)->where('jenis', 'Peringatan')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-info" id="btnDetail" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
    }

    public function roleDetail($peringatan)
    {
        /* Update data notifikasi sesuai parameter */
        NotifikasiModel::where('id', $peringatan)->update(['status' => 'Dibaca']);

        /* Ambil data informasi sesuai parameter */
        $data = NotifikasiModel::with(['informasi' => function($q){
            $q->where('jenis', 'Peringatan');
        },'informasi.tahun'])->find($peringatan);

        /* Return json data informasi */
        return response()->json($data);
    }

    public function indexMhs()
    {
        /* Return menuju view */
        return view('mahasiswa.peringatan.index');
    }
}
