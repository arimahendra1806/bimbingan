<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\DosPemModel;
use App\Models\BimbinganModel;
use App\Models\ProgresBimbinganModel;
use App\Models\KomentarModel;
use App\Models\TahunAjaran;
use App\Models\RiwayatBimbinganModel;
use Carbon\Carbon;
use App\Mail\MailController;
use DataTables, Auth, Validator;

class DsnKonsulProgramController extends Controller
{
    public function index(Request $request){
        /* Ambil data data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->value('id');

        /* Ambil data dosen login */
        $user = User::with(['dosen.dospem' => function($q) use ($tahun_id){
            $q->where('tahun_ajaran_id', $tahun_id);
        }])->find(Auth::user()->id);

        $status_dospem = $user->dosen->dospem;

        /* Ambil data array kode pembimbing */
        if ($status_dospem) {
            $arr_in = $user->dosen->dospem->pluck('kode_pembimbing')->toArray();

            /* Ambil data table daftar mahasiswa */
            if($request->ajax()){
                $data = BimbinganModel::whereIn('pembimbing_kode', $arr_in)
                    ->where('jenis_bimbingan', 'Program')
                    ->where('status_konsultasi', '!=', 'Belum Aktif')
                    ->get()->load('pembimbing.mahasiswa','tinjau');
                return DataTables::of($data)->addIndexColumn()->toJson();
            }
        }

        if ($status_dospem) {
            /* Return menuju view */
            return view('dosen.konsultasi.program.index');
        } else {
            /* Return menuju view */
            return view('dosen.konsultasi.program.dialihkan');
        }
    }

    public function detail(Request $request, $kode){
        /* Ambil data tabel bimbingan sesuai parameter */
        $data = BimbinganModel::with('pembimbing.mahasiswa.judul','tinjau')->where('kode_bimbingan', $kode)
                ->where('jenis_bimbingan', 'Program')
                ->first();

        /* Ambil data array */
        $arr_in = [
            'judul' => $data->pembimbing->mahasiswa->judul->judul,
            'kb' => $data->kode_bimbingan
        ];

        /* Jika data status_pesan bukan 3 */
        if($data->status_pesan != "3"){
            $data->status_pesan = "1";
            $data->save();
        }

        /* Return json dengan data */
        return response()->json(['detail' => $arr_in]);
    }

    public function komen(Request $request, $kode){
        /* Ambil data table komentar sesuai parameter */
        if($request->ajax()){
            $data = KomentarModel::latest()->where('bimbingan_kode', $kode)
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

    public function riwayat(Request $request, $kode)
    {
        /* Ambil data tabel riwayat bimbingan */
        if ($request->ajax()){
            $data = RiwayatBimbinganModel::where('bimbingan_kode', $kode)
                ->where('bimbingan_jenis', "Program")
                ->get()->load('bimbingan');
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('stats', function($model){
                    if ($model->status){
                        if ($model->status == "Disetujui"){
                            return "Disetujui untuk pengujian";
                        } elseif ($model->status == "Selesai") {
                            return "Selesai revisi pengujian";
                        } else {
                            return "Lanjutkan pengerjaan";
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
                        $get_kode = BimbinganModel::where('kode_bimbingan', $model->bimbingan_kode)->where('jenis_bimbingan', 'Program')->first();
                        if ($model->peninjauan_kode == $get_kode->kode_peninjauan) {
                            $btn = '<a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>
                            <a class="btn btn-info" id="btnShow" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>';
                            return $btn;
                        } else {
                            $btn = '<a class="btn btn-info" id="btnShow" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>';
                            return $btn;
                        }
                    } else {
                        $btn = '<a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-secondary" id="btnTinjau" data-toggle="tooltip" title="Pertinjau Video" data-id="'.$model->bimbingan->link_video.'"><i class="fab fa-youtube-square"></i></a>';
                        return $btn;
                    }
                })
                ->rawColumns(['waktu','stats','action'])
                ->toJson();
        }

        /* return json */
        return response()->json();
    }

    public function store(Request $request){
        /* Peraturan validasi  */
        $rules = [
            'progres' => ['required'],
            'keterangan' => ['required'],
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'progres' => 'Status Peninjauan',
            'keterangan' => 'Tanggapan Peninjauan',
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Ambil data tabel bimbingan sesuai parameter */
            $data = BimbinganModel::with('pembimbing.mahasiswa','tinjau')->where('kode_bimbingan', $request->kd)
                ->where('jenis_bimbingan', 'Program')
                ->first();

            /* Jika request progres sama dengan disetujui */
            if($request->progres == "Disetujui"){
                /* Update data progres bimbingan */
                ProgresBimbinganModel::where('bimbingan_kode', $request->kd)->update(['program' => '5']);
            } else {
                /* Update data progres bimbingan */
                ProgresBimbinganModel::where('bimbingan_kode', $request->kd)->update(['program' => '0']);
            }

            /* Update data riwayat */
            $data->tinjau->status = $request->progres;
            $data->tinjau->tanggapan = $request->keterangan;
            $data->tinjau->save();

            /* Update data bimbingan */
            $data->status_konsultasi = "Aktif";
            $data->status_pesan = "3";
            $data->save();

            // /* Notifikasi email */
            // $subjek = 'Tanggapan Konsultasi Program Terbaru';
            // $details = [
            //     'title' => 'Tanggapan Untuk Konsultasi Program Anda',
            //     'body' => 'Anda menerima tanggapan untuk konsultasi program dari Dosen Pembimbing'
            // ];

            // Mail::to($data->pembimbing->mahasiswa->email)->send(new \App\Mail\MailController($details, $subjek));

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Perbarui Peninjauan"]);
        }
    }

    public function show($id)
    {
        /* Ambil data materi dosen sesuai parameter */
        $data = RiwayatBimbinganModel::find($id);

        /* Return json data materi tahunan */
        return response()->json($data);
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
            $user = User::with('dosen.dospem.mahasiswa')->find(Auth::user()->id);
            $bimbingan = BimbinganModel::where('kode_bimbingan', $request->kb)->first();

            /* Kondisi jika status selesai */
            $get_status = RiwayatBimbinganModel::where('peninjauan_kode', $bimbingan->kode_peninjauan)->first();

            /* Ambil data data tahun_ajaran */
            if ($get_status && $get_status->status == "Selesai"){
                $data = "Diskusi ditutup, silahkan lanjut untuk konsultasi berikutnya!";
                return response()->json(['status' => 1, 'data' => $data]);
            } else {
                $data = new KomentarModel;
                $data->bimbingan_kode = $request->kb;
                $data->bimbingan_jenis = "Program";
                $data->users_id = $user->id;
                $data->komentar = $request->komentar;
                $data->save();

                // /* Notifikasi email */
                // $subjek = 'Tanggapan Komentar Konsultasi Program Terbaru';
                // $details = [
                //     'title' => 'Tanggapan Komentar Untuk Konsultasi Program Anda',
                //     'body' => 'Anda menerima tanggapan komentar untuk konsultasi program dari Dosen Pembimbing'
                // ];

                // Mail::to($user->dosen->dospem->mahasiswa->email)->send(new \App\Mail\MailController($details, $subjek));

                /* Return json berhasil */
                return response()->json(['status' => 2, 'msg' => "Success!! Komentar berhasil ditambahkan ..", 'data' => $data]);
            }
        }
    }
}
