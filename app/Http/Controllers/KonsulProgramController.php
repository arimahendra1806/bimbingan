<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\TahunAjaran;
use App\Models\RiwayatBimbinganModel;
use App\Models\KomentarModel;
use App\Models\User;
use Carbon\Carbon;
use App\Mail\MailController;
use DataTables, Auth, File, Validator;

class KonsulProgramController extends Controller
{
    public function index(Request $request)
    {
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data mahasiswa login */
        $user = User::with(['mahasiswa.dospem.bimbingan' => function($q){
            $q->where('jenis_bimbingan', 'Program');
        }])->find(Auth::user()->id);

        $status_dospem = $user->mahasiswa->dospem;

        /* Ambil data array */
        if ($status_dospem) {
            /* Tampilan Info */
            $get_status = RiwayatBimbinganModel::where('peninjauan_kode', $user->mahasiswa->dospem->bimbingan->kode_peninjauan)->first();

            if ($get_status) {
                $status = $get_status->status;
            } else {
                $status = "Belum";
            }

            $detail = [
                'status_konsultasi' => $status,
            ];

            /* Ambil data table Komentar */
            if ($request->ajax()){
                $data = KomentarModel::latest()->where('bimbingan_kode', $user->mahasiswa->dospem->bimbingan->kode_bimbingan)
                    ->where('bimbingan_jenis', 'Program')->get()->load('nama');
                return DataTables::of($data)
                    ->addColumn('waktu', function($model){
                        $waktu = Carbon::parse($model->waktu_komentar)->isoFormat(' | D MMMM Y - HH:mm:ss');
                        return $waktu;
                    })
                    ->rawColumns(['waktu'])
                    ->toJson();
            }
        }

        if ($status_dospem) {
            /* Return menuju view */
            return view('mahasiswa.konsultasi.program.index', compact('tahun_id','detail'));
        } else {
            /* Return menuju view */
            return view('mahasiswa.konsultasi.program.alihkan');
        }
    }

    public function riwayat(Request $request)
    {
        /* Ambil data mahasiswa login */
        $user = User::with('mahasiswa.dospem.bimbingan')->find(Auth::user()->id);

        /* Ambil data tabel riwayat bimbingan */
        if ($request->ajax()){
            $data = RiwayatBimbinganModel::where('bimbingan_kode', $user->mahasiswa->dospem->bimbingan->kode_bimbingan)
                ->where('bimbingan_jenis', "Program")
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('stats', function($model){
                    if ($model->status){
                        if ($model->status == "Disetujui"){
                            return "Disetujui untuk pengujian";
                        } elseif ($model->status == "Selesai") {
                            return "Selesai revisi pengujian";
                        } else {
                            return $model->status;
                        }
                    } else {
                        return "Belum ada tanggapan";
                    }
                })
                ->addColumn('waktu', function($model){
                    $waktu = \Carbon\Carbon::parse($model->waktu_bimbingan)->isoFormat('D MMMM Y / HH:mm:ss');
                    return $waktu;
                })
                ->addColumn('action', function($model){
                    if($model->tanggapan){
                        $btn = '<a class="btn btn-info" id="btnShow" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>';
                        return $btn;
                    } else {
                        $btn = '<a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>';
                        return $btn;
                    }
                })
                ->rawColumns(['waktu','stats','action'])
                ->toJson();
        }

        /* return json */
        return response()->json();
    }

    public function store(Request $request)
    {
        /* Peraturan validasi  */
        $rules = [
            'link_video_add' => ['required'],
            'keterangan_add' => ['required']
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'link_video_add' => 'Link Video Konsultasi',
            'keterangan_add' => 'Deskripsi Konsultasi',
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $get_kondisi = User::with(['mahasiswa.dospem.bimbingan' => function($q){
                $q->where('jenis_bimbingan', 'Proposal');
            }])->find(Auth::user()->id);
            $kd_tinjau = $get_kondisi->mahasiswa->dospem->bimbingan;

            /* Kondisi jika konsultasi proposal belum selesai */
            $cek_kondisi = RiwayatBimbinganModel::where('peninjauan_kode', $kd_tinjau->kode_peninjauan)->first();
            if (!$cek_kondisi || $cek_kondisi->status != "Selesai") {
                $data = "Konsultasi proposal Anda belum selesai, silahkan lanjut untuk konsultasi proposal hingga berstatus 'selesai revisi pengujian'!";
                return response()->json(['status' => 1, 'data' => $data]);
            } else {
                /* Ambil data mahasiswa login */
                $user = User::with(['mahasiswa.dospem.bimbingan' => function($q){
                    $q->where('jenis_bimbingan', 'Program');
                }],'mahasiswa.dospem.dosen')->find(Auth::user()->id);

                $bimbingan = $user->mahasiswa->dospem->bimbingan;

                /* Kondisi jika status selesai */
                $get_status = RiwayatBimbinganModel::where('peninjauan_kode', $bimbingan->kode_peninjauan)->first();

                if ($get_status && $get_status->status == "Selesai"){
                    $data = "Konsultasi ditutup, dikarenakan konsultasi sudah selesai!";
                    return response()->json(['status' => 1, 'data' => $data]);
                } else {
                    /* Kondisi jika tanggapan */
                    if ($get_status && !$get_status->tanggapan) {
                        $data = "Anda baru saja melakukan konsultasi, mohon tunggu tanggapan dari Dosen Pembimbing Anda!";
                        return response()->json(['status' => 1, 'data' => $data]);
                    } elseif (!$get_status || $get_status->tanggapan) {
                        /* Ambil data data tahun_ajaran */
                        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

                        /* Update data table bimbingan */
                        $bimbingan->kode_peninjauan = $bimbingan->kode_bimbingan.time();
                        $bimbingan->tahun_ajaran_id = $tahun_id->id;
                        $bimbingan->link_video = $request->link_video_add;
                        $bimbingan->status_konsultasi = "Aktif";
                        $bimbingan->status_pesan = "0";
                        $bimbingan->save();

                        /* Insert ke table riwayat */
                        $data2 = new RiwayatBimbinganModel;
                        $data2->bimbingan_kode = $bimbingan->kode_bimbingan;
                        $data2->peninjauan_kode = $bimbingan->kode_peninjauan;
                        $data2->bimbingan_jenis = $bimbingan->jenis_bimbingan;
                        $data2->keterangan = $request->keterangan_add;
                        $data2->save();

                        $nomor = '62' . $user->mahasiswa->dospem->dosen->no_telepon;
                        $pesan = 'Anda menerima konsultasi program terbaru dari mahasiswa yang bernama ' . $user->mahasiswa->nama_mahasiswa;

                        $Notif = new WhatsappApiController;
                        $Notif->whatsappNotif($nomor, $pesan);

                        /* Return json berhasil */
                        return response()->json(['status' => 2, 'msg' => "Berhasil Melakukan Konsultasi!", 'data' => ['link_upload' => $bimbingan->link_video, 'status_konsultasi' => $bimbingan->status_konsultasi]]);
                    }
                }
            }
        }
    }

    public function show($konsultasi_program)
    {
        /* Ambil data materi dosen sesuai parameter */
        $data = RiwayatBimbinganModel::find($konsultasi_program)->load('bimbingan');

        /* Return json data materi tahunan */
        return response()->json($data);
    }

    public function update(Request $request, $konsultasi_program)
    {
        /* Peraturan validasi  */
        $rules = [
            'link_video_edit' => ['required'],
            'keterangan_edit' => ['required']
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'link_video_edit' => 'Link Video Konsultasi',
            'keterangan_edit' => 'Deskripsi Konsultasi',
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Ambil data mahasiswa login */
            $user = User::with(['mahasiswa.dospem.bimbingan' => function($q){
                $q->where('jenis_bimbingan', 'Program');
            }],'mahasiswa.dospem.dosen')->find(Auth::user()->id);

            $bimbingan = $user->mahasiswa->dospem->bimbingan;

            /* Ubah Link & status pesan */
            $bimbingan->link_video = $request->link_video_edit;
            $bimbingan->status_pesan = "0";
            $bimbingan->save();

            /* Ubah Keterangan */
            $get_status = RiwayatBimbinganModel::where('peninjauan_kode', $bimbingan->kode_peninjauan)->first();
            $get_status->keterangan = $request->keterangan_edit;
            $get_status->save();

            /* Return json berhasil */
            return response()->json(['status' => 2, 'msg' => "Berhasil Memperbarui Data!"]);
        }
    }

    public function storeKomen(Request $request)
    {
        /* Peraturan validasi  */
        $rules = [
            'komentar' => ['required']
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'komentar' => 'Pesan Komentar'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Ambil data mahasiswa login */
            $user = User::with(['mahasiswa.dospem.bimbingan' => function($q){
                $q->where('jenis_bimbingan', 'Program');
            }],'mahasiswa.dospem.dosen')->find(Auth::user()->id);

            $bimbingan = $user->mahasiswa->dospem->bimbingan;

            /* Kondisi jika status selesai */
            $get_status = RiwayatBimbinganModel::where('peninjauan_kode', $bimbingan->kode_peninjauan)->first();

            /* Ambil data data tahun_ajaran */
            if ($get_status && $get_status->status == "Selesai"){
                $data = "Diskusi ditutup, konsultasi sudah selesai!";
                return response()->json(['status' => 1, 'data' => $data]);
            } else {
                /* Insert ke tabel komentar */
                $data = new KomentarModel;
                $data->bimbingan_kode = $user->mahasiswa->dospem->bimbingan->kode_bimbingan;
                $data->bimbingan_jenis = $user->mahasiswa->dospem->bimbingan->jenis_bimbingan;
                $data->users_id = $user->id;
                $data->komentar = $request->komentar;
                $data->save();

                $nomor = '62' . $user->mahasiswa->dospem->dosen->no_telepon;
                $pesan = 'Anda menerima komentar untuk konsultasi program terbaru dari mahasiswa yang bernama ' . $user->mahasiswa->nama_mahasiswa;

                $Notif = new WhatsappApiController;
                $Notif->whatsappNotif($nomor, $pesan);

                /* Return json berhasil */
                return response()->json(['status' => 2, 'msg' => "Success!! Komentar berhasil ditambahkan ..", 'data' => $data]);
            }
        }
    }
}
