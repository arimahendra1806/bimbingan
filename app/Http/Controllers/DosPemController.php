<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\TahunAjaran;
use App\Models\DosPemModel;
use App\Models\PengajuanJudulModel;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use App\Models\BimbinganModel;
use App\Models\ProgresBimbinganModel;
use App\Mail\MailController;
use App\Http\Controllers\WhatsappApiController;
use DataTables, Validator;

class DosPemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data dosen */
        $dosen_id = DosenModel::all()->sortBy('nama_dosen');

        /* Ambil data mahasiswa */
        $mhs_id = MahasiswaModel::all()->sortBy('nama_mahasiswa');

        /* Ambil data tabel dos_pem */
        if ($request->ajax()){
            $data = DosPemModel::where('tahun_ajaran_id', $tahun_id->id)->get()->load('tahun','mahasiswa','dosen');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>
                    <a id="btnDelete" data-id="'.$model->id.'" class="btn btn-danger" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-prescription-bottle"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        /* Return menuju view */
        return view('koordinator.kelola-dosen-pembimbing.index', compact('tahun_id', 'dosen_id', 'mhs_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* Peraturan validasi, manual karena some reason */
        /* inisiasi request */
        $dsn = $request->dosen_add;
        $mhs = $request->mhs_add;

        /* kondisi jika request kosong */
        if(!$dsn && !$mhs) {
            return response()->json(['status' => 0, 'error' => ['dosen_add' => ['Nama Dosen wajib diisi'], 'mhs_add' => ['Checklist Mahasiswa wajib diisi']]]);
        } elseif(!$dsn) {
            return response()->json(['status' => 0, 'error' => ['dosen_add' => ['Nama Dosen wajib diisi']]]);
        }
        elseif(!$mhs) {
            return response()->json(['status' => 0, 'error' => ['mhs_add' => ['Checklist Mahasiswa wajib diisi']]]);
        } else {
            /* kondisi jika request mhs sama  */
            for($y = 0; $y < count($mhs); $y++)
            {
                $x = DosPemModel::where('mahasiswa_id', $mhs[$y])->first();
                if($x){
                    return response()->json(['status' => 0, 'error' => ['mhs_add' => ['Checklist Mahasiswa sudah ada sebelumnya']]]);
                    break;
                }
            }

            /* Ambil data tahun_ajaran yang aktif */
            $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

            /* Array jenis bimbingan */
            $jenis = ["Judul","Proposal","Laporan","Program"];

            /* Ambil nidn untuk kode */
            $id_dsn = DosenModel::where('id', $dsn)->first();
            $nidn = substr($id_dsn->nidn, -4);

            /* Perulangan sebanyak checkbox requerst mhs */
            for($count = 0; $count < count($mhs); $count++)
            {
                /* Ambil nim untuk kode */
                $id_mhs = MahasiswaModel::where('id', $mhs[$count])->first();
                $nim = substr($id_mhs->nim, -4);

                /* Insert ke tabel dos_pem */
                $data = new DosPemModel;
                $data->kode_pembimbing = "KP".$nidn.$nim.rand(1000,9999);
                $data->dosen_id = $dsn;
                $data->mahasiswa_id = $mhs[$count];
                $data->tahun_ajaran_id = $tahun_id->id;
                $data->save();

                /* Update tabel pengajuan_judul sesuai request mhs */
                PengajuanJudulModel::where('mahasiswa_id', $mhs[$count])->update(['status' => "Mendapat Pembimbing"]);

                /* Perulangan sebanyak jenis */
                for($i = 0; $i < count($jenis); $i++)
                {
                    /* Insert ke tabel bimbingan sebanyak jenis */
                    $data2 = new BimbinganModel;
                    $data2->kode_bimbingan = "KB".substr($data->kode_pembimbing, 2);
                    $data2->pembimbing_kode = $data->kode_pembimbing;
                    $data2->tahun_ajaran_id = $tahun_id->id;
                    $data2->jenis_bimbingan = $jenis[$i];
                    $data2->status_konsultasi = "Belum Aktif";
                    $data2->status_pesan = "0";
                    $data2->save();
                }

                /* Insert ke tabel progres sesiai kode bimbingan */
                $data3 = new ProgresBimbinganModel;
                $data3->bimbingan_kode = $data2->kode_bimbingan;
                $data3->tahun_ajaran_id = $tahun_id->id;
                $data3->save();

                $nomorDsn = '62' . $id_dsn->no_telepon;
                $nomorMhs = '62' . $id_mhs->no_telepon;
                $pesan = 'Penetapan Dosen Pembimbing - Susunan dosen pembimbing untuk Anda: Nama Dosen Pembimbing: ' . $id_dsn->nama_dosen . '; Nama Mahasiswa: ' . $id_mhs->nama_mahasiswa;

                $Notif = new WhatsappApiController;
                $Notif->whatsappNotif($nomorDsn, $pesan);
                $Notif->whatsappNotif($nomorMhs, $pesan);

            }

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Menambahkan Data!"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($dosen_pembimbing)
    {
        /* Ambil data dos_pem sesuai parameter */
        $data = DosPemModel::find($dosen_pembimbing)->load('tahun');

        /* Return json data dos_pem */
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $dosen_pembimbing)
    {
        /* Ambil data users sesuai parameter */
        $data = DosPemModel::where('id', $dosen_pembimbing)->first();

        /* Kondisi data username tidak sama, maka validasi berikut */
        if($data->mahasiswa_id == $request->mhs_edit) {
            /* Peraturan validasi  */
            $rules = [
                'dosen_edit' => ['required'],
            ];
        } else {
            /* Peraturan validasi  */
            $rules = [
                'dosen_edit' => ['required'],
                'mhs_edit' => ['required',"unique:dosen_pembimbing,mahasiswa_id"],
            ];
        }

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'dosen_edit' => 'Nama Dosen',
            'mhs_edit' => 'Nama Mahasiswa'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Update tabel dos_pem */
            $data->dosen_id = $request->dosen_edit;
            $data->mahasiswa_id = $request->mhs_edit;
            $data->save();

            $id_dsn = DosenModel::find($request->dosen_edit);
            $id_mhs = MahasiswaModel::find($request->mhs_edit);

            $nomorDsn = '62' . $id_dsn->no_telepon;
            $nomorMhs = '62' . $id_mhs->no_telepon;
            $pesan = 'Pembaruhan Dosen Pembimbing - Susunan dosen pembimbing untuk Anda: Nama Dosen Pembimbing: ' . $id_dsn->nama_dosen . '; Nama Mahasiswa: ' . $id_mhs->nama_mahasiswa;

            $Notif = new WhatsappApiController;
            $Notif->whatsappNotif($nomorDsn, $pesan);
            $Notif->whatsappNotif($nomorMhs, $pesan);

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Memperbarui Data!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($dosen_pembimbing)
    {
        /* Ambil data dos_pem sesuai parameter */
        $dospem = DosPemModel::find($dosen_pembimbing);

        /* Update data pengajuan sesuai data dos_pem */
        PengajuanJudulModel::where('mahasiswa_id', $dospem->mahasiswa_id)->update(['status' => "Diproses"]);

        /* Hapus data dos_pem */
        $dospem->forceDelete();

        /* Return json berhasil */
        return response()->json(['msg' => "Berhasil Menghapus Data!"]);
    }

    public function judul(Request $request){
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data tabel judul */
        if ($request->ajax()){
            $data = PengajuanJudulModel::where('tahun_ajaran_id', $tahun_id->id)->where('status', 'diproses')->get()->load('mahasiswa','anggota');
            return DataTables::of($data)->toJson();
        }

        /* return json */
        return response()->json();
    }

    public function jumlahNidn($id)
    {
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data dos_pem sesuai parameter */
        $countId = DosPemModel::where('dosen_id', $id)->where('tahun_ajaran_id', $tahun_id->id)->count('id');

        /* Return json data dos_pem */
        return response()->json(['data' => $countId]);
    }
}
