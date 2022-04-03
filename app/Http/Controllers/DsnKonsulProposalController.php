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

class DsnKonsulProposalController extends Controller
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
                ->where('jenis_bimbingan', 'Proposal')
                ->where('status_konsultasi', '!=', 'Belum Konsultasi')
                ->get()->load('pembimbing.mahasiswa');
            return DataTables::of($data)->addIndexColumn()->toJson();
        }

        /* Return menuju view */
        return view('dosen.konsultasi.proposal.index');
    }

    public function detail(Request $request, $kode){
        /* Ambil data tabel bimbingan sesuai parameter */
        $data = BimbinganModel::with('pembimbing.mahasiswa.judul','progres')->where('kode_bimbingan', $kode)
                ->where('jenis_bimbingan', 'Proposal')
                ->first();

        /* Ambil data array */
        $arr_in = [
            'kd' => $data->kode_bimbingan,
            'nama' => $data->pembimbing->mahasiswa->nama_mahasiswa,
            'tanggal' => $data->tanggal_konsultasi,
            'judul' => $data->pembimbing->mahasiswa->judul->judul,
            'file' => $data->file_upload,
            'status' => $data->status_konsultasi,
            'keterangan' => $data->keterangan_konsultasi
        ];

        /* Inisiasi data array status */
        $arr_status = array();
        /* Inisiasi data array jenis */
        $arr_jenis = array("proposal_bab1", "proposal_bab2", "proposal_bab3", "proposal_bab4");

        /* Perulangan cek data progres lebih dari 0 */
        foreach ($arr_jenis as $key => $value_jenis) {
            if($data->progres->$value_jenis > 0){
                array_push($arr_status, $value_jenis);
            }
        }

        /* Kondisi jika array status kosong */
        if(count($arr_status) == 0 && $data->keterangan_konsultasi){
            array_push($arr_status, "Revisi");
        }

        /* Jika data status_pesan bukan 3 */
        if($data->status_pesan != "3"){
            $data->status_pesan = "1";
            $data->save();
        }

        /* Return json dengan data */
        return response()->json(['detail' => $arr_in, 'status' => $arr_status]);
    }

    public function komen(Request $request, $kode){
        /* Ambil data table komentar sesuai parameter */
        if($request->ajax()){
            $data = KomentarModel::latest()->where('bimbingan_kode', $kode)
                ->where('bimbingan_jenis', 'Proposal')->get();
            return DataTables::of($data)->toJson();
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
            /* Inisiasi progres */
            $progres = $request->progres;

            /* Inisiasi array select */
            $select = array();
            /* Inisiasi array jenis */
            $arr_jenis = array("proposal_bab1", "proposal_bab2", "proposal_bab3", "proposal_bab4");

            /* Perulangan untuk mengambil data yg diselect */
            for ($i = 0; $i < count($progres); $i++)
            {
                array_push($select, $progres[$i]);
            }

            /* Kondisi jika select lebih dari 1 dan berisi revisi */
            if(count($select) > 1 && in_array("Revisi", $select)){
                return response()->json(['status' => 0, 'error' => ['progres' => ['Status Konsultasi yang dipilih tidak valid.']]]);
            } else {
                /* Ambil data tabel bimbingan sesuai parameter */
                $data = BimbinganModel::with('pembimbing.mahasiswa.judul', 'progres')->where('kode_bimbingan', $request->kd)
                    ->where('jenis_bimbingan', 'Proposal')
                    ->first();

                /* Kondisi jika di array select ada kata revisi */
                if(in_array("Revisi", $select)){
                    /* Perulangan update data progres sesuai parameter array jenis */
                    foreach ($arr_jenis as $key => $value_jenis) {
                        ProgresBimbinganModel::where('bimbingan_kode', $request->kd)->update([$value_jenis => '0']);
                    }

                    /* Update data tabel bimbingan */
                    $data->status_konsultasi = "Revisi";
                    $data->keterangan_konsultasi = $request->keterangan;
                    $data->status_pesan = "3";
                    $data->save();

                    /* Inisiasi array status */
                    $arr_status = "Revisi";
                } else {
                    /* Inisiasi array unselect */
                    $unselect = array_diff($arr_jenis, $select);
                    /* Inisiasi buang kata proposal_ di array select */
                    $y = str_replace(array('proposal_'), '',$unselect);
                    /* Inisiasi tambah kata , di array select */
                    $x = implode(", ",$y);
                    /* Inisiasi tambah kata revisi di array select */
                    $status = "Revisi ".$x;

                    /* Perulangan update data progres sesuai parameter array select */
                    foreach ($select as $key => $value_select) {
                        ProgresBimbinganModel::where('bimbingan_kode', $request->kd)->update([$value_select => '7.5']);
                    }

                    /* Perulangan update data progres sesuai parameter array unselect */
                    foreach ($unselect as $key => $value_unselect) {
                        ProgresBimbinganModel::where('bimbingan_kode', $request->kd)->update([$value_unselect => '0']);
                    }

                    /* Kondisi jika total select sama dengan 4 */
                    if(count($select) == 4){
                        $data->status_konsultasi = "Disetujui";
                    } else {
                        $data->status_konsultasi = $status;
                    }

                    /* Update tabel bimbingan */
                    $data->keterangan_konsultasi = $request->keterangan;
                    $data->status_pesan = "3";
                    $data->save();

                    /* Inisiasi array status */
                    $arr_status = $select;
                }

                /* Return json berhasil */
                return response()->json(['status' => 1, 'msg' => "Berhasil Perbarui Peninjauan"]);
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
            $user = User::with(['dosen.dospem.bimbingan' => function($q){
                $q->where('jenis_bimbingan', 'Proposal');
            }])->find(Auth::user()->id);

            /* Ambil data data tahun_ajaran */
            if($user->dosen->dospem->bimbingan->status_konsultasi == "Disetujui"){
                $data = "Diskusi ditutup, silahkan lanjut untuk peninjauan berikutnya!";
                return response()->json(['status' => 1, 'data' => $data]);
            } else {
                /* Insert ke tabel komentar */
                $data = new KomentarModel;
                $data->bimbingan_kode = $user->dosen->dospem->bimbingan->kode_bimbingan;
                $data->bimbingan_jenis = $user->dosen->dospem->bimbingan->jenis_bimbingan;
                $data->nama = $user->dosen->nama_dosen;
                $data->komentar = $request->komentar;
                $data->save();

                /* Return json berhasil */
                return response()->json(['status' => 2, 'msg' => "Success!! Komentar berhasil ditambahkan ..", 'data' => $data]);
            }
        }
    }
}
