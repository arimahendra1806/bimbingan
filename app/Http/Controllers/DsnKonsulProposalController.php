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

class DsnKonsulProposalController extends Controller
{
    public function index(Request $request){
        /* Ambil data data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->value('id');

        /* Ambil data dosen login */
        $user = User::with('dosen')->find(Auth::user()->id);

        $get_status = DosPemModel::where('dosen_id', $user->dosen->id)->where('tahun_ajaran_id', $tahun_id)->get();

        /* Ambil data array kode pembimbing */
        if (!$get_status->isEmpty()) {
            $arr_in = $get_status->pluck('kode_pembimbing')->toArray();

            /* Ambil data table daftar mahasiswa */
            if($request->ajax()){
                $data = BimbinganModel::whereIn('pembimbing_kode', $arr_in)
                    ->where('jenis_bimbingan', 'Proposal')
                    ->where('status_konsultasi', '!=', 'Belum Aktif')
                    ->get()->load('pembimbing.mahasiswa','tinjau');
                return DataTables::of($data)->addIndexColumn()->toJson();
            }
        }

        if (!$get_status->isEmpty()) {
            /* Return menuju view */
            return view('dosen.konsultasi.proposal.index');
        } else {
            /* Return menuju view */
            return view('dosen.konsultasi.proposal.dialihkan');
        }
    }

    public function detail(Request $request, $kode){
        /* Ambil data tabel bimbingan sesuai parameter */
        $data = BimbinganModel::with('pembimbing.mahasiswa.judul','progres','tinjau')->where('kode_bimbingan', $kode)
                ->where('jenis_bimbingan', 'Proposal')
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
                ->where('bimbingan_jenis', 'Proposal')->get()->load('nama');
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
                ->where('bimbingan_jenis', "Proposal")
                ->get()->load('bimbingan');
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
                        $get_kode = BimbinganModel::where('kode_bimbingan', $model->bimbingan_kode)->where('jenis_bimbingan', 'Proposal')->first();
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
                        <a class="btn btn-secondary" id="btnDownload" data-toggle="tooltip" title="Download File" data-id="'.$model->id.'" href="dokumen/konsultasi/proposal/'.$model->bimbingan->file_upload.'" download><i class="fas fa-download"></i></a>';
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
                $data = BimbinganModel::with('pembimbing.mahasiswa.judul', 'progres','tinjau')->where('kode_bimbingan', $request->kd)
                    ->where('jenis_bimbingan', 'Proposal')
                    ->first();

                /* Kondisi jika di array select ada kata revisi */
                if(in_array("Revisi", $select)){
                    /* Perulangan update data progres sesuai parameter array jenis */
                    foreach ($arr_jenis as $key => $value_jenis) {
                        ProgresBimbinganModel::where('bimbingan_kode', $request->kd)->update([$value_jenis => '0']);
                    }

                    /* Update data riwayat */
                    $data->tinjau->status = "Revisi";
                    $data->tinjau->tanggapan = $request->keterangan;
                    $data->tinjau->save();

                    /* Update data bimbingan */
                    $data->status_konsultasi = "Aktif";
                    $data->status_pengujian = "0";
                    $data->status_pesan = "3";
                    $data->save();
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
                        if ($request->status_cek == "on") {
                            $data->tinjau->status = "Selesai";
                            $data->status_pengujian = "2";
                        } else {
                            $data->tinjau->status = "Disetujui";
                            $data->status_pengujian = "1";
                        }
                    } else {
                        $data->tinjau->status = $status;
                        $data->status_pengujian = "0";
                    }

                    $data->tinjau->tanggapan = $request->keterangan;
                    $data->tinjau->save();

                    /* Update data bimbingan */
                    $data->status_konsultasi = "Aktif";
                    $data->status_pesan = "3";
                    $data->save();
                }

                // /* Notifikasi email */
                // $subjek = 'Tanggapan Konsultasi Proposal Terbaru';
                // $details = [
                //     'title' => 'Tanggapan Untuk Konsultasi Proposal Anda',
                //     'body' => 'Anda menerima tanggapan untuk konsultasi proposal dari Dosen Pembimbing'
                // ];

                // Mail::to($data->pembimbing->mahasiswa->email)->send(new \App\Mail\MailController($details, $subjek));

                /* Return json berhasil */
                return response()->json(['status' => 1, 'msg' => "Berhasil Perbarui Peninjauan"]);
            }
        }
    }

    public function show($id)
    {
        /* Ambil data materi dosen sesuai parameter */
        $data = RiwayatBimbinganModel::with('bimbingan.progres')->find($id);

        /* Inisiasi data array status */
        $arr_status = array();
        /* Inisiasi data array jenis */
        $arr_jenis = array("proposal_bab1", "proposal_bab2", "proposal_bab3", "proposal_bab4");

        /* Perulangan cek data progres lebih dari 0 */
        foreach ($arr_jenis as $key => $value_jenis) {
            if($data->bimbingan->progres->$value_jenis > 0){
                array_push($arr_status, $value_jenis);
            }
        }

        /* Kondisi jika array status kosong */
        if(count($arr_status) == 0 && $data->status){
            array_push($arr_status, "Revisi");
        }

        /* Return json data materi tahunan */
        return response()->json(['data' => $data, 'status' => $arr_status]);
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
            $bimbingan = BimbinganModel::where('kode_bimbingan', $request->kb)->where('jenis_bimbingan', 'Proposal')->first();

            /* Kondisi jika status selesai */
            $get_status = RiwayatBimbinganModel::where('peninjauan_kode', $bimbingan->kode_peninjauan)->first();

            /* Ambil data data tahun_ajaran */
            if ($get_status && $get_status->status == "Selesai"){
                $data = "Diskusi ditutup, silahkan lanjut untuk peninjauan berikutnya!";
                return response()->json(['status' => 1, 'data' => $data]);
            } else {
                /* Insert ke tabel komentar */
                $data = new KomentarModel;
                $data->bimbingan_kode = $request->kb;
                $data->bimbingan_jenis = "Proposal";
                $data->users_id = $user->id;
                $data->komentar = $request->komentar;
                $data->save();

                // /* Notifikasi email */
                // $subjek = 'Tanggapan Komentar Konsultasi Proposal Terbaru';
                // $details = [
                //     'title' => 'Tanggapan Komentar Untuk Konsultasi Proposal Anda',
                //     'body' => 'Anda menerima tanggapan komentar untuk konsultasi proposal dari Dosen Pembimbing'
                // ];

                // Mail::to($user->dosen->dospem->mahasiswa->email)->send(new \App\Mail\MailController($details, $subjek));

                /* Return json berhasil */
                return response()->json(['status' => 2, 'msg' => "Success!! Komentar berhasil ditambahkan ..", 'data' => $data]);
            }
        }
    }
}
