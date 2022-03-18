<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\RiwayatBimbinganModel;
use App\Models\KomentarModel;
use App\Models\User;
use DataTables, Auth, File, Validator;

class KonsulProposalController extends Controller
{
    public function index(Request $request)
    {
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data mahasiswa login */
        $user = User::with(['mahasiswa.dospem.bimbingan' => function($q){
            $q->where('jenis_bimbingan', 'Proposal');
        }])->find(Auth::user()->id);

        /* Ambil data table Komentar */
        if ($request->ajax()){
            $data = KomentarModel::latest()->where('bimbingan_kode', $user->mahasiswa->dospem->bimbingan->kode_bimbingan)
                ->where('bimbingan_jenis', 'Proposal')->get();
            return DataTables::of($data)->toJson();
        }

        /* Return menuju view */
        return view('mahasiswa.konsultasi.proposal.index', compact('tahun_id','user'));
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
                $q->where('jenis_bimbingan', 'Proposal');
            }])->find(Auth::user()->id);
            $bimbingan = $user->mahasiswa->dospem->bimbingan;

            /* Kondisi jika status disetujui */
            if($bimbingan->status_konsultasi == "Disetujui"){
                $data = "Konsultasi proposal sudah selesai, silahkan lanjut untuk konsultasi berikutnya!";
                return response()->json(['status' => 1, 'data' => $data]);
            } else {
                /* Ambil data data tahun_ajaran */
                $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

                /* Simpan file bimbingan */
                $file = $request->file('file_upload');
                $filename = time()."_".$file->getClientOriginalName();
                $file->move(public_path('dokumen/konsultasi/proposal'), $filename);
                /* Hapus file bimbingan sebelumnya */
                File::delete('dokumen/konsultasi/proposal/'.$request->fileShow);

                /* Update data table bimbingan */
                $bimbingan->file_upload = $filename;
                $bimbingan->status_konsultasi = "Belum Disetujui";
                $bimbingan->status_pesan = "0";
                $bimbingan->save();

                /* Insert ke table riwayat */
                $data2 = new RiwayatBimbinganModel;
                $data2->bimbingan_kode = $bimbingan->kode_bimbingan;
                $data2->bimbingan_jenis = $bimbingan->jenis_bimbingan;
                $data2->save();

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
                $q->where('jenis_bimbingan', 'Proposal');
            }])->find(Auth::user()->id);

            /* Ambil data data tahun_ajaran */
            if($user->mahasiswa->dospem->bimbingan->status_konsultasi == "Disetujui"){
                $data = "Konsultasi proposal sudah selesai, silahkan lanjut untuk konsultasi berikutnya!";
                return response()->json(['status' => 1, 'data' => $data]);
            } else {
                /* Insert ke tabel komentar */
                $data = new KomentarModel;
                $data->bimbingan_kode = $user->mahasiswa->dospem->bimbingan->kode_bimbingan;
                $data->bimbingan_jenis = $user->mahasiswa->dospem->bimbingan->jenis_bimbingan;
                $data->nama = $user->mahasiswa->nama_mahasiswa;
                $data->komentar = $request->komentar;
                $data->save();

                /* Return json berhasil */
                return response()->json(['status' => 2, 'msg' => "Success!! Komentar berhasil ditambahkan ..", 'data' => $data]);
            }
        }
    }
}