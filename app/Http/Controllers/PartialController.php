<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\DosPemMateriModel;
use App\Models\RiwayatBimbinganModel;
use App\Models\User;
use App\Models\DosPemModel;
use App\Models\PengajuanZoomModel;
use App\Models\PengajuanZoomAnggotaModel;
use DataTables, Auth;

class PartialController extends Controller
{
    public function MateriKonsul(Request $request, $jenis)
    {
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data mahasiswa login */
        $user = User::with('mahasiswa.dospem')->find(Auth::user()->id);

        /* Ambil data tabel dos_pem materi */
        if ($request->ajax()){
            $data = DosPemMateriModel::where('dosen_id', $user->mahasiswa->dospem->dosen_id)
                ->where('tahun_ajaran_id', $tahun_id->id)
                ->where('jenis_materi', $jenis)
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-info" id="btnDownload" data-toggle="tooltip" title="Download Ketentuan" data-id="'.$model->id.'" href="/dokumen/pembimbing-materi/'.$model->file_materi.'" download><i class="fas fa-download"></i></a>';
                    return $btn;
                })
                ->toJson();
        }

        /* return json */
        return response()->json();
    }

    public function RiwayatKonsul(Request $request, $jenis)
    {
        /* Ambil data mahasiswa login */
        $user = User::with('mahasiswa.dospem.bimbingan')->find(Auth::user()->id);

        /* Ambil data tabel riwayat bimbingan */
        if ($request->ajax()){
            $data = RiwayatBimbinganModel::where('bimbingan_kode', $user->mahasiswa->dospem->bimbingan->kode_bimbingan)
                ->where('bimbingan_jenis', $jenis)
                ->get();
            return DataTables::of($data)->addIndexColumn()->toJson();
        }

        /* return json */
        return response()->json();
    }

    public function JadwalZoom(Request $request)
    {
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data mahasiswa login */
        $user = User::with('mahasiswa.dospem')->find(Auth::user()->id);

        /* Ambil data dospem sesuai data mahasiswa */
        $dospem = DosPemModel::where('dosen_id', $user->mahasiswa->dospem->dosen_id)
            ->where('tahun_ajaran_id', $tahun_id->id)->get();

        /* Inisiasi array kode pembimbing */
        $arr_dospem = $dospem->pluck('kode_pembimbing')->toArray();

        /* Ambil data tabel pengajuan */
        if ($request->ajax()){
            $data = PengajuanZoomModel::whereIn('pembimbing_kode', $arr_dospem)
                ->where('tahun_ajaran_id', $tahun_id->id)
                ->where('status', 'Diterima')
                ->latest()->get()->load('tahun','pembimbing.mahasiswa');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-primary" id="btnGabung" data-id="'.$model->kode_anggota_zoom.'">Gabung</i></a>';
                    return $btn;
                })
                ->addColumn('total', function($model){
                    $total = PengajuanZoomAnggotaModel::where('anggota_zoom_kode', $model->kode_anggota_zoom)->count('id');
                    return $total;
                })
                ->rawColumns(['total','action'])
                ->toJson();
        }
    }

    public function JadwalZoomStore(Request $request, $kode)
    {
        /* Ambil data mahasiswa login */
        $user = User::with('mahasiswa.dospem')->find(Auth::user()->id);
        /* Inisasisi variabel sesuai data mahasiswa login */
        $kp = $user->mahasiswa->dospem->kode_pembimbing;

        /* Inisiasi count anggota zoom */
        $jmlAnggota = PengajuanZoomAnggotaModel::where('anggota_zoom_kode', $kode)->count('id');

        /* Kondisi jika jmlAnggota lebih atau sama dgn 5 */
        if($jmlAnggota >= 5){
            /* Return json gagal */
            return response()->json(['status' => 1, 'msg' => "Anda tidak dapat bergabung! Karena kuota sudah terpenuhi!"]);
        } else {
            /* Ambil data pengajuan sesuai parameter */
            $pengajuan = PengajuanZoomModel::where('kode_anggota_zoom', $kode)->first();

            /* Ambil data anggota sesuai parameter */
            $anggota = PengajuanZoomAnggotaModel::where('anggota_zoom_kode', $kode)
                ->where('pembimbing_kode', $kp)->first();

            /* Kondisi untuk validasi insert anggota */
            if ($pengajuan->pembimbing_kode == $kp){
                /* Return json gagal */
                return response()->json(['status' => 1, 'msg' => "Anda tidak dapat bergabung! Karena Anda yang mengajukan!"]);
            } elseif($anggota) {
                /* Return json gagal */
                return response()->json(['status' => 1, 'msg' => "Anda tidak dapat bergabung! Karena Anda sudah bergabung!"]);
            } else {
                /* Insert zoom anggota */
                $data = new PengajuanZoomAnggotaModel;
                $data->anggota_zoom_kode = $kode;
                $data->pembimbing_kode = $kp;
                $data->save();

                /* Return json berjasil */
                return response()->json(['status' => 2, 'msg' => "Anda berhasil bergabung dengan jadwal zoom ini!"]);
            }
        }
    }

    public function RiwayatJadwalZoom(Request $request)
    {
        /* Ambil data mahasiswa login */
        $user = User::with('mahasiswa.dospem')->find(Auth::user()->id);

        /* Ambil data tabel anggota */
        if ($request->ajax()){
            $data = PengajuanZoomAnggotaModel::where('pembimbing_kode', $user->mahasiswa->dospem->kode_pembimbing)
                ->latest()->get()->load('jadwal');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-info" id="btnRiwayat" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
    }

    public function RiwayatJadwalZoomShow($riwayat)
    {
        /* Ambil data anggota sesuai parameter */
        $data = PengajuanZoomAnggotaModel::find($riwayat)->load('jadwal.pembimbing.zoom');

        /* Return json data anggota */
        return response()->json($data);
    }
}
