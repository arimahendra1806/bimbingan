<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PengajuanZoomModel;
use App\Models\PengajuanZoomAnggotaModel;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Models\DosPemModel;
use DataTables, Auth, Validator;

class PengajuanZoomController extends Controller
{
    public function index(Request $request)
    {
        /* Ambil data mahasiswa login */
        $user = User::with('mahasiswa.dospem')->find(Auth::user()->id);

        $status_dospem = $user->mahasiswa->dospem;

        /* Ambil data tabel pengajuan */
        if ($status_dospem) {
            if ($request->ajax()){
                $data = PengajuanZoomModel::where('pembimbing_kode', $user->mahasiswa->dospem->kode_pembimbing)
                    ->latest()->get()->load('tahun');
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($model){
                        $btn = '<a class="btn btn-info" id="btnShow" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>
                        <a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->toJson();
            }
        }

        if ($status_dospem) {
            /* Return menuju view */
            return view('mahasiswa.pengajuan-zoom.index');
        } else {
            /* Return menuju view */
            return view('mahasiswa.pengajuan-zoom.alihkan');
        }
    }

    public function store(Request $request)
    {
        /* Peraturan validasi  */
        $rules = [
            'jam_add' => ['required'],
            // 'tanggal_add' => ['required','unique:pengajuan_jadwal_zoom,tanggal']
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'jam_add' => 'Jam Pengajuan',
            'tanggal_add' => 'Tanggal Pengajuan'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Ambil data tahun_ajaran */
            $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

            /* Ambil data pembimbing mahasiswa login */
            $user = User::with('mahasiswa.dospem')->find(Auth::user()->id);

            $get_dospem = DosPemModel::where('dosen_id', $user->mahasiswa->dospem->dosen_id)->where('tahun_ajaran_id', $tahun_id->id)->get();
            $get_kode = $get_dospem->pluck('kode_pembimbing')->toArray();
            $get_tanggal = PengajuanZoomModel::whereIn('pembimbing_kode', $get_kode)->get()->pluck('tanggal')->toArray();

            if(in_array($request->tanggal_add, $get_tanggal)) {
                return response()->json(['status' => 0, 'error' => ['tanggal_add' => ['Tanggal Pengajuan sudah ada']]]);
            }

            /* Insert pengajuan zoom */
            $data = new PengajuanZoomModel;
            $data->kode_anggota_zoom = Str::random(10);
            $data->tahun_ajaran_id = $tahun_id->id;
            $data->pembimbing_kode = $user->mahasiswa->dospem->kode_pembimbing;
            $data->jam = $request->jam_add;
            $data->tanggal = $request->tanggal_add;
            $data->status = "Diajukan";
            $data->save();

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Menambahkan Data!"]);
        }
    }

    public function show($pengajuan_zoom)
    {
        /* Ambil data pengajuan sesuai parameter */
        $data = PengajuanZoomModel::find($pengajuan_zoom)->load('pembimbing.zoom');

        /* Return json data pengajuan */
        return response()->json($data);
    }

    public function update(Request $request, $pengajuan_zoom)
    {
        /* Peraturan validasi  */
        $rules = [
            'jam_edit' => ['required'],
            // 'tanggal_edit' => ['required','unique:pengajuan_jadwal_zoom,tanggal']
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'jam_edit' => 'Jam Pengajuan',
            'tanggal_edit' => 'Tanggal Pengajuan'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Ambil data pengajuan sesuai parameter */
            $data = PengajuanZoomModel::where('id', $pengajuan_zoom)->first();

            /* Kondisi jika status bukan diajukan */
            if($data->status != "Diajukan"){
                /* Kondisi jika status diterima */
                if ($data->status == "Diterima") {
                    $pesan = "Pengajuan jadwal Anda telah Diterima. Anda tidak dapat memperbarui data pengajuan tersebut";
                } elseif ($data->status == "Tidak Diterima") {
                    $pesan = "Pengajuan jadwal Anda berstatus Tidak Diterima. Silahkan mengajukan jadwal berikutnya.";
                }
                /* Return json message */
                return response()->json(['status' => 1, 'msg' => $pesan]);
            } else {
                /* Ambil data tahun_ajaran */
                $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

                /* Ambil data pembimbing mahasiswa login */
                $user = User::with('mahasiswa.dospem')->find(Auth::user()->id);

                $get_dospem = DosPemModel::where('dosen_id', $user->mahasiswa->dospem->dosen_id)->where('tahun_ajaran_id', $tahun_id->id)->get();
                $get_kode = $get_dospem->pluck('kode_pembimbing')->toArray();
                $get_tanggal = PengajuanZoomModel::whereIn('pembimbing_kode', $get_dospem)->pluck('tanggal')->toArray();

                if($data->tanggal != $request->tanggal_edit) {
                    if(in_array($request->tanggal_edit, $get_tanggal)) {
                        return response()->json(['status' => 0, 'error' => ['tanggal_edit' => ['Tanggal Pengajuan sudah ada']]]);
                    }
                }

                /* Update pengajuan zoom */
                $data->jam = $request->jam_edit;
                $data->tanggal = $request->tanggal_edit;
                $data->status = "Diajukan";
                $data->save();
            }

            /* Return json berhasil */
            return response()->json(['status' => 2, 'msg' => "Berhasil Memperbarui Data!"]);
        }
    }

    public function indexDsn(Request $request)
    {
        /* Ambil data data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->value('id');

        /* Ambil data dosen login */
        $user = User::with('dosen')->find(Auth::user()->id);

        $get_status = DosPemModel::where('dosen_id', $user->dosen->id)->where('tahun_ajaran_id', $tahun_id)->get();

        /* Ambil data array kode pembimbing */
        if ($get_status){
            $arr_in = $get_status->pluck('kode_pembimbing')->toArray();

            /* Ambil data tabel pengajuan */
            if ($request->ajax()){
                $data = PengajuanZoomModel::whereIn('pembimbing_kode', $arr_in)->latest()
                    ->get()->load('tahun','pembimbing.mahasiswa');
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($model){
                        $btn = '<a class="btn btn-info" id="btnShow" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>
                        <a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->toJson();
            }
        }

        if ($get_status){
            /* Return menuju view */
            return view('dosen.peninjauan-jadwal-zoom.index');
        } else {
            /* Return menuju view */
            return view('dosen.peninjauan-jadwal-zoom.dialihkan');
        }
    }

    public function showDsn($peninjauan_zoom)
    {
        /* Ambil data pengajuan sesuai parameter */
        $data = PengajuanZoomModel::find($peninjauan_zoom)->load('pembimbing.zoom','pembimbing.mahasiswa','anggota_zoom');

        /* data anggota sesuai data pengajuan */
        $anggota = PengajuanZoomAnggotaModel::with('pembimbing.mahasiswa')->where('anggota_zoom_kode', $data->kode_anggota_zoom)->get();

        /* Inisiasi array */
        $arr_data = array();

        /* Perulangan untuk mengisi array sesuai data anggota */
        foreach ($anggota as $key => $value) {
            array_push($arr_data, $value->pembimbing->mahasiswa->nama_mahasiswa);
        }

        /* Return json data pengajuan */
        return response()->json(['data' => $data, 'anggota' => $arr_data]);
    }

    public function updateDsn(Request $request, $peninjauan_zoom)
    {
        /* Peraturan validasi  */
        $rules = [
            'status_edit' => ['required'],
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'status_edit' => 'Status Pengajuan',
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Update pengajuan zoom */
            $data = PengajuanZoomModel::where('id', $peninjauan_zoom)->first();
            $data->status = $request->status_edit;
            $data->save();

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Memperbarui Data!"]);
        }
    }
}
