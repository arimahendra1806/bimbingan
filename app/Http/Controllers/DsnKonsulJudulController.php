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
use Carbon\Carbon;
use App\Mail\MailController;
use DataTables, Auth, Validator;

class DsnKonsulJudulController extends Controller
{
    public function index(Request $request){
        /* Ambil data data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->value('id');

        /* Ambil data dosen login */
        $user = User::with(['dosen.dospem' => function($q) use ($tahun_id){
            $q->where('tahun_ajaran_id', $tahun_id);
        }])->find(Auth::user()->id);

        /* Ambil data array kode pembimbing */
        $arr_in = $user->dosen->dospem->pluck('kode_pembimbing')->toArray();

        /* Ambil data table daftar mahasiswa */
        if($request->ajax()){
            $data = BimbinganModel::whereIn('pembimbing_kode', $arr_in)
                ->where('jenis_bimbingan', 'Judul')
                ->where('status_konsultasi', '!=', 'Belum Konsultasi')
                ->get()->load('pembimbing.mahasiswa');
            return DataTables::of($data)->addIndexColumn()->toJson();
        }

        /* Return menuju view */
        return view('dosen.konsultasi.judul.index');
    }

    public function detail(Request $request, $kode){
        /* Ambil data tabel bimbingan sesuai parameter */
        $data = BimbinganModel::with('pembimbing.mahasiswa.judul')->where('kode_bimbingan', $kode)
                ->where('jenis_bimbingan', 'Judul')
                ->first();
        $tgl = Carbon::parse($data->tanggal_konsultasi)->isoFormat('D MMMM Y');

        /* Ambil data array */
        $arr_in = [
            'kd' => $data->kode_bimbingan,
            'nama' => $data->pembimbing->mahasiswa->nama_mahasiswa,
            'tanggal' => $tgl,
            'judul' => $data->pembimbing->mahasiswa->judul->judul,
            'file' => $data->file_upload,
            'status' => $data->status_konsultasi,
            'keterangan' => $data->keterangan_konsultasi
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
                ->where('bimbingan_jenis', 'Judul')->get();
            return DataTables::of($data)
                ->addColumn('waktu', function($model){
                    $waktu = Carbon::parse($model->waktu_komentar)->isoFormat('(D MMMM Y - hh:mm:ss)');
                    return $waktu;
                })
                ->rawColumns(['waktu'])
                ->toJson();
        }
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
            'progres' => 'Status Konsultasi',
            'keterangan' => 'Keterangan',
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Ambil data tabel bimbingan sesuai parameter */
            $data = BimbinganModel::with('pembimbing.mahasiswa.judul')->where('kode_bimbingan', $request->kd)
                ->where('jenis_bimbingan', 'Judul')
                ->first();

            /* Jika request progres sama dengan disetujui */
            if($request->progres == "Disetujui"){
                /* Update data progres bimbingan */
                ProgresBimbinganModel::where('bimbingan_kode', $request->kd)->update(['judul' => '5']);

                /* Update data judul */
                $data->pembimbing->mahasiswa->judul->status = "Diterima";
                $data->pembimbing->mahasiswa->judul->save();
            } else {
                /* Update data progres bimbingan */
                ProgresBimbinganModel::where('bimbingan_kode', $request->kd)->update(['judul' => '0']);

                /* Update data judul */
                $data->pembimbing->mahasiswa->judul->status = "Mendapat Pembimbing";
                $data->pembimbing->mahasiswa->judul->save();
            }

            /* Update data judul */
            $data->status_konsultasi = $request->progres;
            $data->keterangan_konsultasi = $request->keterangan;
            $data->status_pesan = "3";
            $data->save();

            // /* Notifikasi email */
            // $subjek = 'Tanggapan Konsultasi Judul Terbaru';
            // $details = [
            //     'title' => 'Tanggapan Untuk Konsultasi Judul Anda',
            //     'body' => 'Anda menerima tanggapan untuk konsultasi judul dari Dosen Pembimbing'
            // ];

            // Mail::to($data->pembimbing->mahasiswa->email)->send(new \App\Mail\MailController($details, $subjek));

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Perbarui Peninjauan", 'data' => $data]);
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
            $user = User::with('dosen.dospem.mahasiswa')->find(Auth::user()->id);
            $bimbingan = BimbinganModel::where('kode_bimbingan', $request->kb)->first();

            /* Ambil data data tahun_ajaran */
            if($bimbingan->status_konsultasi == "Disetujui"){
                $data = "Diskusi ditutup, silahkan lanjut untuk peninjauan berikutnya!";
                return response()->json(['status' => 1, 'data' => $data]);
            } else {
                /* Insert ke tabel komentar */
                $data = new KomentarModel;
                $data->bimbingan_kode = $request->kb;
                $data->bimbingan_jenis = "Judul";
                $data->nama = $user->dosen->nama_dosen;
                $data->komentar = $request->komentar;
                $data->save();

                // /* Notifikasi email */
                // $subjek = 'Tanggapan Komentar Konsultasi Judul Terbaru';
                // $details = [
                //     'title' => 'Tanggapan Komentar Untuk Konsultasi Judul Anda',
                //     'body' => 'Anda menerima tanggapan komentar untuk konsultasi judul dari Dosen Pembimbing'
                // ];

                // Mail::to($user->dosen->dospem->mahasiswa->email)->send(new \App\Mail\MailController($details, $subjek));

                /* Return json berhasil */
                return response()->json(['status' => 2, 'msg' => "Success!! Komentar berhasil ditambahkan ..", 'data' => $data]);
            }
        }
    }
}
