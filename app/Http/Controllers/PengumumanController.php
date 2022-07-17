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
use App\Models\InformasiKepadaModel;
use App\Models\FileInformasiModel;
use App\Mail\MailController;
use DataTables, Validator, Auth, File;

class PengumumanController extends Controller
{
    private function addNotif($array, $data_id){
        $data_pesan = InformasiModel::find($data_id);

        /* Perulangan insert data notifikasi sesuai parameter && notifikasi email */
        foreach ($array as $key => $value) {
            $penerima = User::with('dosen','mahasiswa')->find($value);

            if ($penerima->dosen){
                $nomor = '62' . $penerima->dosen->no_telepon;
                $pesan = 'Pengumuman : ' . $data_pesan->judul . '. ' . $data_pesan->pesan;

                $Notif = new WhatsappApiController;
                $Notif->whatsappNotif($nomor, $pesan);

            } elseif ($penerima->mahasiswa){
                $nomor = '62' . $penerima->mahasiswa->no_telepon;
                $pesan = 'Pengumuman : ' . $data_pesan->judul . '. ' . $data_pesan->pesan;

                $Notif = new WhatsappApiController;
                $Notif->whatsappNotif($nomor, $pesan);
            }

            $data2 = new NotifikasiModel;
            $data2->informasi_id = $data_id;
            $data2->kepada = $value;
            $data2->jenis = "Pengumuman";
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
        $arr_adm = User::where('role', "admin")->pluck('id')->toArray();
        $arr_kp = User::where('role', "kaprodi")->pluck('id')->toArray();

        /* Kondisi jika role kepada */
        if ($kepada_role == "semua pengguna"){
            /* Kondisi jika user akses role sesuai */
            if ($user_role == "koordinator") {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($arr_dsn, $data_info_id);
                $this->addNotif($arr_mhs, $data_info_id);
                $this->addNotif($arr_adm, $data_info_id);
                $this->addNotif($arr_kp, $data_info_id);
            } elseif ($user_role == "kaprodi") {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($arr_koor, $data_info_id);
                $this->addNotif($arr_dsn, $data_info_id);
                $this->addNotif($arr_mhs, $data_info_id);
                $this->addNotif($arr_adm, $data_info_id);
            }
        } elseif($kepada_role == "koordinator admin dosen") {
            /* Jalankan function addNotif sesuai dengan parameter */
            $this->addNotif($arr_koor, $data_info_id);
            $this->addNotif($arr_dsn, $data_info_id);
            $this->addNotif($arr_adm, $data_info_id);
        } elseif($kepada_role == "koordinator admin") {
            /* Jalankan function addNotif sesuai dengan parameter */
            $this->addNotif($arr_koor, $data_info_id);
            $this->addNotif($arr_adm, $data_info_id);
        } elseif($kepada_role == "koordinator dosen"){
            /* Jalankan function addNotif sesuai dengan parameter */
            $this->addNotif($arr_koor, $data_info_id);
            $this->addNotif($arr_dsn, $data_info_id);
        } elseif($kepada_role == "dosen admin") {
            if ($user_role == "koordinator") {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($arr_dsn, $data_info_id);
                $this->addNotif($arr_adm, $data_info_id);
                $this->addNotif($arr_kp, $data_info_id);
            } elseif ($user_role == "kaprodi") {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($arr_dsn, $data_info_id);
                $this->addNotif($arr_adm, $data_info_id);
            }
        } elseif($kepada_role == "dosen mahasiswa"){
            if ($user_role == "koordinator") {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($arr_dsn, $data_info_id);
                $this->addNotif($arr_mhs, $data_info_id);
                $this->addNotif($arr_kp, $data_info_id);
            } elseif ($user_role == "kaprodi") {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($arr_dsn, $data_info_id);
                $this->addNotif($arr_mhs, $data_info_id);
            }
        } elseif ($kepada_role == "koordinator"){
            /* Kondisi jika kepada sama dengan 0 */
            if (in_array('0', $kepada_id)) {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($arr_koor, $data_info_id);
            } else {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($data_info_role, $data_info_id);
            }
        } elseif ($kepada_role == "dosen"){
            /* Kondisi jika kepada sama dengan 0 */
            if (in_array('0', $kepada_id)) {
                if ($user_role == "koordinator") {
                    /* Jalankan function addNotif sesuai dengan parameter */
                    $this->addNotif($arr_dsn, $data_info_id);
                    $this->addNotif($arr_kp, $data_info_id);
                } elseif ($user_role == "kaprodi") {
                    /* Jalankan function addNotif sesuai dengan parameter */
                    $this->addNotif($arr_dsn, $data_info_id);
                }
            } else {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($data_info_role, $data_info_id);
            }
        } elseif($kepada_role == "admin") {
            /* Kondisi jika kepada sama dengan 0 */
            if (in_array('0', $kepada_id)) {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($arr_adm, $data_info_id);
            } else {
                /* Jalankan function addNotif sesuai dengan parameter */
                $this->addNotif($data_info_role, $data_info_id);
            }
        } elseif ($kepada_role == "mahasiswa"){
            /* Kondisi jika kepada sama dengan 0 */
            if (in_array('0', $kepada_id)) {
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
            $data = InformasiModel::latest()->where('jenis', 'Pengumuman')
                ->where('users_id', $user_id)->get()->load('tahun');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('role_kepada', function($model){
                    if ($model->kepada_role == 'semua pengguna') {
                        return $model->kepada_role;
                    } else {
                        return str_replace(' ', ', ', $model->kepada_role);
                    }
                })
                ->addColumn('kepadaDetail', function($model){
                    $kepada = InformasiKepadaModel::where('informasi_id', $model->id)->get();
                    $count_in = $kepada->count('id');
                    if ($count_in == 2) {
                        $data_id = $kepada->pluck('users_id')->toArray();
                        $x = array();
                        foreach ($data_id as $key => $value) {
                            $data_nama = User::where('id', $value)->first();
                            array_push($x, $data_nama->name);
                        }
                        $y = implode(", ", $x);
                        return $y;
                    } elseif ($count_in > 2) {
                        return $count_in . ' orang lainnya';
                    } else {
                        $cek = InformasiKepadaModel::with('nama')->where('informasi_id', $model->id)->first();
                        if ($cek->users_id == '0'){
                            return 'Semua';
                        } else {
                            return $cek->nama->name;
                        }
                    }
                })
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-info" id="btnShow" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>
                    <a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>
                    <a id="btnDelete" data-id="'.$model->id.'" class="btn btn-danger delete-user" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-prescription-bottle"></i></a>';
                    return $btn;
                })
                ->rawColumns(['role_kepada','kepadaDetail','action'])
                ->toJson();
        }

        /* Return menuju view */
        return view('partial.kelola-pengumuman.index', compact('tahun_id'));
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
                'file_upload_add' => ['required'],
                'file_upload_add.*' => ['file','max:2048','mimes:pdf,docx,jpg,jpeg,png,xlxs,ppt,txt'],
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
            'judul_add' => 'Judul Pengumuman',
            'subyek_add' => 'Subyek Pengumuman',
            'pesan_add' => 'Pesan Pengumuman',
            'file_upload_add' => 'Lampiran File',
            'file_upload_add.*' => 'Lampiran File'
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
            if (count($request->kepada_add) > 1 && in_array('0', $request->kepada_add)){
                return response()->json(['status' => 0, 'error' => ['kepada_add' => ['Kepada yang dipilih tidak valid']]]);
            } else {
                $data = new InformasiModel;
                $data->users_id = $user_id;
                $data->tahun_ajaran_id = $tahun_id->id;
                $data->kepada_role = $request->kepada_role_add;
                $data->judul = $request->judul_add;
                $data->subyek = $request->subyek_add;
                $data->pesan = $request->pesan_add;
                $data->jenis = "Pengumuman";
                $data->save();

                foreach ($request->kepada_add as $key => $value) {
                    $data2 = new InformasiKepadaModel;
                    $data2->informasi_id = $data->id;
                    $data2->users_id = $value;
                    $data2->save();
                }

                /* Jika request terdapat file */
                if ($request->hasFile('file_upload_add')){
                    $file = $request->file('file_upload_add');
                    foreach ($file as $key => $value) {
                        $filename = time()."_".$value->getClientOriginalName();
                        $value->move(public_path('dokumen/pengumuman'), $filename);

                        $data3 = new FileInformasiModel;
                        $data3->informasi_id = $data->id;
                        $data3->nama_file = $filename;
                        $data3->save();
                    }
                }

                /* Inisiasi variabel setelah insert */
                $data_info_id = $data->id;
                $data_info_role = $request->kepada_add;

                /* Jalankan function kondisiNotif sesuai dengan parameter */
                $this->kondisiNotif($request->kepada_role_add, $request->kepada_add, $data_info_role, $data_info_id);
            }

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Menambahkan Data!"]);
        }
    }

    public function show($pengumuman)
    {
        /* Ambil data informasi sesuai parameter */
        $data = InformasiModel::find($pengumuman)->load('tahun');

        $kepada = InformasiKepadaModel::where('informasi_id', $data->id)->get();
        $count_in = $kepada->count('id');
        if ($count_in > 1) {
            $data_id = $kepada->pluck('users_id')->toArray();
            $x = array();
            foreach ($data_id as $key => $value) {
                $data_nama = User::where('id', $value)->first();
                array_push($x, $data_nama->name);
            }
            $nama = implode(", ", $x);
            $selectNm = $data_id;
        } else {
            $cek = InformasiKepadaModel::with('nama')->where('informasi_id', $data->id)->first();
            if ($cek->users_id == '0'){
                $nama = "Semua";
                $selectNm = "0";
            } else {
                $nama = $cek->nama->name;
                $selectNm = $cek->users_id;
            }
        }
        if ($data->kepada_role == 'semua pengguna') {
            $role = $data->kepada_role;
        } else {
            $role = str_replace(' ', ', ', $data->kepada_role);
        }

        /* Return json data informasi */
        return response()->json(['data' => $data, 'nama' => $nama, 'selectNm' => $selectNm, 'role' => $role]);
    }

    public function update(Request $request, $pengumuman)
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
                'file_upload_edit' => ['required'],
                'file_upload_edit.*' => ['file','max:2048','mimes:pdf,docx,jpg,jpeg,png,xlxs,ppt,txt'],
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
            'judul_edit' => 'Judul Pengumuman',
            'subyek_edit' => 'Subyek Pengumuman',
            'pesan_edit' => 'Pesan Pengumuman',
            'file_upload_edit' => 'Lampiran File',
            'file_upload_edit.*' => 'Lampiran File'
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
            if (count($request->kepada_edit) > 1 && in_array('0', $request->kepada_edit)){
                return response()->json(['status' => 0, 'error' => ['kepada_edit' => ['Kepada yang dipilih tidak valid']]]);
            } else {
                /* Ambil data infomasi sesuai parameter */
                $data = InformasiModel::where('id', $pengumuman)->first();

                /* Hapus data notifikasi sesuai dengan parameter */
                $get_cek = InformasiKepadaModel::where('informasi_id', $data->id)->get();
                $cek = $get_cek->pluck('users_id')->toArray();
                if ($cek != $request->kepada_edit) {
                    NotifikasiModel::where('informasi_id', $data->id)
                        ->where('jenis', 'Pengumuman')->forceDelete();
                    InformasiKepadaModel::where('informasi_id', $data->id)
                        ->forceDelete();
                }

                /* Update pengumuman */
                $data->users_id = $user_id;
                $data->tahun_ajaran_id = $tahun_id->id;
                $data->kepada_role = $request->kepada_role_edit;
                $data->judul = $request->judul_edit;
                $data->subyek = $request->subyek_edit;
                $data->pesan = $request->pesan_edit;
                $data->jenis = "Pengumuman";
                $data->save();

                if ($cek != $request->kepada_edit) {
                    foreach ($request->kepada_edit as $key => $value) {
                        $data2 = new InformasiKepadaModel;
                        $data2->informasi_id = $data->id;
                        $data2->users_id = $value;
                        $data2->save();
                    }
                }

                /* Jika request terdapat file */
                if ($request->hasFile('file_upload_edit')){
                    $file = $request->file('file_upload_edit');
                    foreach ($file as $key => $value) {
                        $filename = time()."_".$value->getClientOriginalName();
                        $value->move(public_path('dokumen/pengumuman'), $filename);

                        $data3 = new FileInformasiModel;
                        $data3->informasi_id = $data->id;
                        $data3->nama_file = $filename;
                        $data3->save();
                    }
                }

                /* Inisiasi variabel setelah insert */
                $data_info_id = $data->id;
                $data_info_role = $request->kepada_edit;

                if ($cek != $request->kepada_edit) {
                    /* Jalankan function addNotif sesuai dengan parameter */
                    $this->kondisiNotif($request->kepada_role_edit, $request->kepada_edit, $data_info_role, $data_info_id);
                }
            }

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Memperbarui Data!"]);
        }
    }

    public function destroy($pengumuman)
    {
        /* Hapus data informasi sesuai parameter */
        $data = InformasiModel::with('file')->find($pengumuman);

        /* Hapus data file public */
        $arr_in = $data->file->pluck('nama_file')->toArray();
        foreach ($arr_in as $key => $value) {
            $path = public_path() . '/dokumen/pengumuman/' . $value;
            File::delete($path);
        }

        /* Hapus data informasi */
        $data->forceDelete();

        /* Return json berhasil */
        return response()->json(['msg' => "Berhasil Menghapus Data!"]);
    }

    public function kepada($pengumuman){
        /* Ambil data user login */
        $user_id = Auth::user()->id;
        $user_role = Auth::user()->role;

        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Kondisi jika pengumuman sesuai role */
        if ($pengumuman == "koordinator"){
            /* Inisiasi variabel data sesuai parameter kondisi */
            $data = User::where('role', "koordinator")->select('id', 'name')->orderBy('name')->get();
        } elseif ($pengumuman == "dosen"){
            /* Inisiasi variabel data sesuai parameter kondisi */
            if ($user_role == "kaprodi"){
                $data = User::where('role', "dosen")->select('id', 'name')->orderBy('name')->get();
            } else {
                $data = User::where('role', "dosen")->orWhere('role', "kaprodi")->select('id', 'name')->orderBy('name')->get();
            }
        } elseif ($pengumuman == "admin"){
            /* Inisiasi variabel data sesuai parameter kondisi */
            $data = User::where('role', "admin")->select('id', 'name')->orderBy('name')->get();
        } elseif ($pengumuman == "mahasiswa") {
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
                $q->where('jenis', 'Pengumuman');
            },'informasi.tahun' => function($q){
                $q->select('id','tahun_ajaran');
            },'informasi.pengirim' => function($q){
                $q->select('id','name','role');
            }])->latest()->where('kepada', $user_id)->where('jenis', 'Pengumuman')->get();
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

    public function roleDetail($pengumuman)
    {
        /* Update data notifikasi sesuai parameter */
        NotifikasiModel::where('id', $pengumuman)->update(['status' => 'Dibaca']);

        /* Ambil data informasi sesuai parameter */
        $data = NotifikasiModel::with(['informasi' => function($q){
            $q->where('jenis', 'Pengumuman');
        },'informasi.tahun'])->find($pengumuman);

        /* Return json data informasi */
        return response()->json($data);
    }

    public function indexMhs()
    {
        /* Return menuju view */
        return view('mahasiswa.pengumuman.index');
    }

    public function tEdit(Request $request, $id) {
        if ($request->ajax()){
            $data = FileInformasiModel::where('informasi_id', $id)->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-secondary" id="tBtnDownload" data-toggle="tooltip" title="Download File" data-id="'.$model->id.'" href="/dokumen/pengumuman/'.$model->nama_file.'" download><i class="fas fa-download"></i></a>
                    <a class="btn btn-danger" id="tBtnDelete" data-toggle="tooltip" title="Hapus File" data-id="'.$model->id.'"><i class="fas fa-prescription-bottle"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
    }

    public function tShow(Request $request, $id) {
        if ($request->ajax()){
            $data = FileInformasiModel::where('informasi_id', $id)->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-secondary" id="tBtnDownload" data-toggle="tooltip" title="Download File" data-id="'.$model->id.'" href="/dokumen/pengumuman/'.$model->nama_file.'" download><i class="fas fa-download"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
    }

    public function tDelete($id)
    {
        /* Ambil data materi tahunan sesuai parameter */
        $data = FileInformasiModel::find($id);

        /* Hapus data file public */
        $path = public_path() . '/dokumen/pengumuman/' . $data->nama_file;
        File::delete($path);

        /* Hapus data materi tahunan */
        $data->forceDelete();

        /* Return json berhasil */
        return response()->json(['msg' => "Berhasil Menghapus File!"]);
    }
}
