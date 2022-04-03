<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DosPemModel;
use App\Models\BimbinganModel;
use App\Models\ProgresBimbinganModel;
use App\Models\KomentarModel;
use App\Models\TahunAjaran;
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

        /* Ambil data array kode pembimbing */
        $arr_in = $user->dosen->dospem->pluck('kode_pembimbing')->toArray();

        /* Ambil data table daftar mahasiswa */
        if($request->ajax()){
            $data = BimbinganModel::whereIn('pembimbing_kode', $arr_in)
                ->where('jenis_bimbingan', 'Program')
                ->where('status_konsultasi', '!=', 'Belum Konsultasi')
                ->get()->load('pembimbing.mahasiswa');
            return DataTables::of($data)->addIndexColumn()->toJson();
        }

        /* Return menuju view */
        return view('dosen.konsultasi.program.index');
    }

    public function detail(Request $request, $kode){
        /* Ambil data tabel bimbingan sesuai parameter */
        $data = BimbinganModel::with('pembimbing.mahasiswa.judul')->where('kode_bimbingan', $kode)
                ->where('jenis_bimbingan', 'Program')
                ->first();

        /* Ambil data array */
        $arr_in = [
            'kd' => $data->kode_bimbingan,
            'nama' => $data->pembimbing->mahasiswa->nama_mahasiswa,
            'tanggal' => $data->tanggal_konsultasi,
            'judul' => $data->pembimbing->mahasiswa->judul->judul,
            'link' => $data->link_video,
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
                ->where('bimbingan_jenis', 'Program')->get();
            return DataTables::of($data)->toJson();
        }
    }

    public function store(Request $request){
        /* Peraturan validasi  */
        $rules = [
            // 'progres' => ['required'],
            'keterangan' => ['required'],
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            // 'progres' => 'Status Konsultasi',
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
            $data = BimbinganModel::with('pembimbing.mahasiswa')->where('kode_bimbingan', $request->kd)
                ->where('jenis_bimbingan', 'Program')
                ->first();

            ProgresBimbinganModel::where('bimbingan_kode', $request->kd)->update(['program' => '5']);

            /* Update data progra */
            $data->status_konsultasi = "Lanjutkan Pengerjaan";
            $data->keterangan_konsultasi = $request->keterangan;
            $data->status_pesan = "3";
            $data->save();

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Perbarui Peninjauan"]);
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
            $user = User::with(['dosen.dospem.bimbingan' => function($q){
                $q->where('jenis_bimbingan', 'Program');
            }])->find(Auth::user()->id);

                /* Insert ke tabel komentar */
                $data = new KomentarModel;
                $data->bimbingan_kode = $user->dosen->dospem->bimbingan->kode_bimbingan;
                $data->bimbingan_jenis = $user->dosen->dospem->bimbingan->jenis_bimbingan;
                $data->nama = $user->dosen->nama_dosen;
                $data->komentar = $request->komentar;
                $data->save();

                /* Return json berhasil */
                return response()->json(['status' => 2, 'msg' => "Success!! Komentar berhasil ditambahkan ..", 'data' => $data]);
            // }
        }
    }
}
