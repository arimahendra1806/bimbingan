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
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use App\Models\PengajuanJudulModel;
use App\Models\ProgresBimbinganModel;
use App\Models\KomentarModel;
use App\Models\FileDosPemMateriModel;
use Carbon\Carbon;
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
                    $btn = '<a class="btn btn-info" id="btnShow" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>';
                    return $btn;
                })
                ->addColumn('jml_file', function($model){
                    $data = FileDosPemMateriModel::where('materi_dospem_id', $model->id)->count('id');
                    return $data;
                })
                ->toJson();
        }

        /* return json */
        return response()->json();
    }

    public function show($id)
    {
        /* Ambil data materi dosen sesuai parameter */
        $data = DosPemMateriModel::find($id)->load('tahun');

        /* Return json data materi tahunan */
        return response()->json($data);
    }

    public function tShow(Request $request, $id) {
        if ($request->ajax()){
            $data = FileDosPemMateriModel::where('materi_dospem_id', $id)->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-secondary" id="tBtnDownload" data-toggle="tooltip" title="Download File" data-id="'.$model->id.'" href="/dokumen/pembimbing-materi/'.$model->nama_file.'" download><i class="fas fa-download"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
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
        if($jmlAnggota >= 10){
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

    public function chartPie(Request $request)
    {
        /* Inisiasi array series pieJmlDsnMhs */
        $pieJmlDsnMhs = array();
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();
        $dosen = DosenModel::all()->count('id');
        array_push($pieJmlDsnMhs, $dosen);
        $mahasiswa = MahasiswaModel::where('tahun_ajaran_id', $tahun_id->id)->count('id');
        array_push($pieJmlDsnMhs, $mahasiswa);

        /* Inisiasi array series pieJmlPengajuanJudul */
        $pieJmlPengajuanJudul = array();
        $mengajukan = PengajuanJudulModel::where('tahun_ajaran_id', $tahun_id->id)->count('id');
        array_push($pieJmlPengajuanJudul, $mengajukan);
        $get_mhs = $mahasiswa;
        $blm_mengajukan = ($get_mhs - $mengajukan);
        array_push($pieJmlPengajuanJudul, $blm_mengajukan);

        /* Inisiasi array series jmlJuduldisetujui */
        $jmlJuduldisetujui = array();
        $disetujui = PengajuanJudulModel::where('tahun_ajaran_id', $tahun_id->id)->where('status', '!=', 'Diproses')->count('id');
        array_push($jmlJuduldisetujui, $disetujui);
        $blm_disetujui = PengajuanJudulModel::where('tahun_ajaran_id', $tahun_id->id)->where('status', 'Diproses')->count('id');
        array_push($jmlJuduldisetujui, $blm_disetujui);

        return response()->json(['pieJmlDsnMhs' => $pieJmlDsnMhs, 'pieJmlPengajuanJudul' => $pieJmlPengajuanJudul, 'jmlJuduldisetujui' => $jmlJuduldisetujui]);
    }

    public function chartColumn(Request $request)
    {
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();
        $jml_angkatan = MahasiswaModel::where('tahun_ajaran_id', $tahun_id->id)->count('id');

        $selesaiA = array();
        /* Selesai judul & proposal */
        $get_judul_sl = ProgresBimbinganModel::where('tahun_ajaran_id', $tahun_id->id)->where('judul', '!=', '0')->count('id');
        array_push($selesaiA, $get_judul_sl);
        $get_proposal_bab1_sl = ProgresBimbinganModel::where('tahun_ajaran_id', $tahun_id->id)->where('proposal_bab1', '!=', '0')->count('id');
        array_push($selesaiA, $get_proposal_bab1_sl);
        $get_proposal_bab2_sl = ProgresBimbinganModel::where('tahun_ajaran_id', $tahun_id->id)->where('proposal_bab2', '!=', '0')->count('id');
        array_push($selesaiA, $get_proposal_bab2_sl);
        $get_proposal_bab3_sl = ProgresBimbinganModel::where('tahun_ajaran_id', $tahun_id->id)->where('proposal_bab3', '!=', '0')->count('id');
        array_push($selesaiA, $get_proposal_bab3_sl);
        $get_proposal_bab4_sl = ProgresBimbinganModel::where('tahun_ajaran_id', $tahun_id->id)->where('proposal_bab4', '!=', '0')->count('id');
        array_push($selesaiA, $get_proposal_bab4_sl);

        $selesaiB = array();
        /* Selesai program & laporan */
        $get_program_sl = ProgresBimbinganModel::where('tahun_ajaran_id', $tahun_id->id)->where('program', '!=', '0')->count('id');
        array_push($selesaiB, $get_program_sl);
        $get_laporan_bab1_sl = ProgresBimbinganModel::where('tahun_ajaran_id', $tahun_id->id)->where('laporan_bab1', '!=', '0')->count('id');
        array_push($selesaiB, $get_laporan_bab1_sl);
        $get_laporan_bab2_sl = ProgresBimbinganModel::where('tahun_ajaran_id', $tahun_id->id)->where('laporan_bab2', '!=', '0')->count('id');
        array_push($selesaiB, $get_laporan_bab2_sl);
        $get_laporan_bab3_sl = ProgresBimbinganModel::where('tahun_ajaran_id', $tahun_id->id)->where('laporan_bab3', '!=', '0')->count('id');
        array_push($selesaiB, $get_laporan_bab3_sl);
        $get_laporan_bab4_sl = ProgresBimbinganModel::where('tahun_ajaran_id', $tahun_id->id)->where('laporan_bab4', '!=', '0')->count('id');
        array_push($selesaiB, $get_laporan_bab4_sl);
        $get_laporan_bab5_sl = ProgresBimbinganModel::where('tahun_ajaran_id', $tahun_id->id)->where('laporan_bab5', '!=', '0')->count('id');
        array_push($selesaiB, $get_laporan_bab5_sl);
        $get_laporan_bab6_sl = ProgresBimbinganModel::where('tahun_ajaran_id', $tahun_id->id)->where('laporan_bab6', '!=', '0')->count('id');
        array_push($selesaiB, $get_laporan_bab6_sl);

        $belumA = array();
        /* Belum judul & proposal */
        $tot_get_judul_bl = ($jml_angkatan - $get_judul_sl);
        array_push($belumA, $tot_get_judul_bl);
        $tot_get_proposal_bab1_bl = ($jml_angkatan - $get_proposal_bab1_sl);
        array_push($belumA, $tot_get_proposal_bab1_bl);
        $tot_get_proposal_bab2_bl = ($jml_angkatan - $get_proposal_bab2_sl);
        array_push($belumA, $tot_get_proposal_bab2_bl);
        $tot_get_proposal_bab3_bl = ($jml_angkatan - $get_proposal_bab3_sl);
        array_push($belumA, $tot_get_proposal_bab3_bl);
        $tot_get_proposal_bab4_bl = ($jml_angkatan - $get_proposal_bab4_sl);
        array_push($belumA, $tot_get_proposal_bab4_bl);

        $belumB = array();
        /* Belum program & laporan */
        $tot_get_program_bl = ($jml_angkatan - $get_program_sl);
        array_push($belumB, $tot_get_program_bl);
        $tot_get_laporan_bab1_bl = ($jml_angkatan - $get_laporan_bab1_sl);
        array_push($belumB, $tot_get_laporan_bab1_bl);
        $tot_get_laporan_bab2_bl = ($jml_angkatan - $get_laporan_bab2_sl);
        array_push($belumB, $tot_get_laporan_bab2_bl);
        $tot_get_laporan_bab3_bl = ($jml_angkatan - $get_laporan_bab3_sl);
        array_push($belumB, $tot_get_laporan_bab3_bl);
        $tot_get_laporan_bab4_bl = ($jml_angkatan - $get_laporan_bab4_sl);
        array_push($belumB, $tot_get_laporan_bab4_bl);
        $tot_get_laporan_bab5_bl = ($jml_angkatan - $get_laporan_bab5_sl);
        array_push($belumB, $tot_get_laporan_bab5_bl);
        $tot_get_laporan_bab6_bl = ($jml_angkatan - $get_laporan_bab6_sl);
        array_push($belumB, $tot_get_laporan_bab6_bl);

        return response()->json(['selesaiA' => $selesaiA, 'belumA' => $belumA, 'selesaiB' => $selesaiB, 'belumB' => $belumB]);
    }

    public function chartLine(Request $request)
    {
        $nm_bulan = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Des');
        $vl_bulan = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        $now = Carbon::now();

        $get_jml = (12 - $now->month);

        for ($i=0; $i < $get_jml; $i++) {
            array_pop($nm_bulan);
            array_pop($vl_bulan);
        }

        $data_konsultasi = array();
        $data_komentar = array();

        foreach ($vl_bulan as $key => $value) {
            $get_bulan_konsul = RiwayatBimbinganModel::whereYear('waktu_bimbingan', $now->year)->whereMonth('waktu_bimbingan', $value)->count('id');
            array_push($data_konsultasi, $get_bulan_konsul);
        }

        foreach ($vl_bulan as $key => $value) {
            $get_bulan_komen = KomentarModel::whereYear('waktu_komentar', $now->year)->whereMonth('waktu_komentar', $value)->count('id');
            array_push($data_komentar, $get_bulan_komen);
        }

        return response()->json(['nm_bulan' => $nm_bulan, 'data_konsultasi' => $data_konsultasi, 'data_komentar' => $data_komentar]);
    }
}
