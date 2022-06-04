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
use DataTables, Auth, File, Validator, PDF;

class KonsulLaporanController extends Controller
{
    public function index(Request $request)
    {
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data mahasiswa login */
        $user = User::with(['mahasiswa.dospem.bimbingan' => function($q){
            $q->where('jenis_bimbingan', 'Laporan');
        }])->find(Auth::user()->id);

        /* Ambil data array */
        $detail = [
            'kode_bimbingan' => $user->mahasiswa->dospem->bimbingan->kode_bimbingan,
            'status_konsultasi' => $user->mahasiswa->dospem->bimbingan->status_konsultasi,
            'keterangan' => $user->mahasiswa->dospem->bimbingan->keterangan_konsultasi,
            'file' => $user->mahasiswa->dospem->bimbingan->file_upload
        ];

        /* Ambil data table Komentar */
        if ($request->ajax()){
            $data = KomentarModel::latest()->where('bimbingan_kode', $user->mahasiswa->dospem->bimbingan->kode_bimbingan)
                ->where('bimbingan_jenis', 'Laporan')->get();
            return DataTables::of($data)
                ->addColumn('waktu', function($model){
                    $waktu = Carbon::parse($model->waktu_komentar)->isoFormat('(D MMMM Y - hh:mm:ss)');
                    return $waktu;
                })
                ->rawColumns(['waktu'])
                ->toJson();
        }

        /* Return menuju view */
        return view('mahasiswa.konsultasi.laporan.index', compact('tahun_id','detail'));
    }

    public function store(Request $request)
    {
        /* Peraturan validasi  */
        $rules = [
            'file_upload' => ['required','file','max:2048','mimes:pdf']
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'file_upload' => 'File Konsultasi'
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
                $q->where('jenis_bimbingan', 'Laporan');
            }],'mahasiswa.dospem.dosen')->find(Auth::user()->id);
            $bimbingan = $user->mahasiswa->dospem->bimbingan;

            /* Kondisi jika status disetujui */
            if($bimbingan->status_konsultasi == "Disetujui"){
                $data = "Konsultasi laporan sudah selesai, silahkan lanjut untuk konsultasi berikutnya!";
                return response()->json(['status' => 1, 'data' => $data]);
            } else {
                /* Ambil data data tahun_ajaran */
                $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

                /* Simpan file bimbingan */
                $file = $request->file('file_upload');
                $filename = time()."_".$file->getClientOriginalName();
                $file->move(public_path('dokumen/konsultasi/laporan'), $filename);
                /* Hapus file bimbingan sebelumnya */
                File::delete('dokumen/konsultasi/laporan/'.$request->fileShow);

                /* Update data table bimbingan */
                $bimbingan->file_upload = $filename;
                $bimbingan->status_konsultasi = "Belum Disetujui";
                $bimbingan->tanggal_konsultasi = Carbon::now();
                $bimbingan->status_pesan = "0";
                $bimbingan->save();

                /* Insert ke table riwayat */
                $data2 = new RiwayatBimbinganModel;
                $data2->bimbingan_kode = $bimbingan->kode_bimbingan;
                $data2->bimbingan_jenis = $bimbingan->jenis_bimbingan;
                $data2->save();

                // /* Notifikasi email */
                // $subjek = 'Konsultasi Laporan Terbaru';
                // $details = [
                //     'title' => 'Konsultasi Laporan dari Mahasiswa Bimbingan Anda',
                //     'body' => 'Anda menerima konsultasi laporan terbaru dari mahasiswa yang bernama ' . $user->mahasiswa->nama_mahasiswa
                // ];

                // Mail::to($user->mahasiswa->dospem->dosen->email)->send(new \App\Mail\MailController($details, $subjek));

                /* Return json berhasil */
                return response()->json(['status' => 2, 'msg' => "Berhasil Melakukan Konsultasi!", 'data' => ['file_upload' => $bimbingan->file_upload, 'status_konsultasi' => $bimbingan->status_konsultasi]]);
            }
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
                $q->where('jenis_bimbingan', 'Laporan');
            }],'mahasiswa.dospem.dosen')->find(Auth::user()->id);

            /* Ambil data data tahun_ajaran */
            if($user->mahasiswa->dospem->bimbingan->status_konsultasi == "Disetujui"){
                $data = "Diskusi ditutup, silahkan lanjut untuk konsultasi berikutnya!";
                return response()->json(['status' => 1, 'data' => $data]);
            } else {
                /* Insert ke tabel komentar */
                $data = new KomentarModel;
                $data->bimbingan_kode = $user->mahasiswa->dospem->bimbingan->kode_bimbingan;
                $data->bimbingan_jenis = $user->mahasiswa->dospem->bimbingan->jenis_bimbingan;
                $data->nama = $user->mahasiswa->nama_mahasiswa;
                $data->komentar = $request->komentar;
                $data->save();

                // /* Notifikasi email */
                // $subjek = 'Komentar Konsultasi Laporan Terbaru';
                // $details = [
                //     'title' => 'Komentar Untuk Konsultasi Laporan dari Mahasiswa Bimbingan Anda',
                //     'body' => 'Anda menerima komentar untuk konsultasi laporan terbaru dari mahasiswa yang bernama ' . $user->mahasiswa->nama_mahasiswa
                // ];

                // Mail::to($user->mahasiswa->dospem->dosen->email)->send(new \App\Mail\MailController($details, $subjek));

                /* Return json berhasil */
                return response()->json(['status' => 2, 'msg' => "Success!! Komentar berhasil ditambahkan ..", 'data' => $data]);
            }
        }
    }

    public function cetakPdf()
    {
    	/* Ambil data mahasiswa login */
        $user = User::with(['mahasiswa.dospem.bimbingan' => function($q){
            $q->where('jenis_bimbingan', 'Laporan');
        }],'mahasiswa.dospem.dosen','mahasiswa.judul','mahasiswa.tahun')->find(Auth::user()->id);
        $riwayat = RiwayatBimbinganModel::where('bimbingan_kode', $user->mahasiswa->dospem->bimbingan->kode_bimbingan)
            ->where('bimbingan_jenis', 'Laporan')
            ->get();

        $hari = Carbon::now()->isoFormat('D MMMM Y');

    	$pdf = PDF::loadview('/mahasiswa/konsultasi/laporan/laporan_pdf', compact('user','riwayat','hari'));
    	return $pdf->stream();
    }
}
