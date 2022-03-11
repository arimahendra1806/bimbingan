<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DosPemModel;
use App\Models\TahunAjaran;
use App\Models\DosPemMateriModel;
use App\Models\BimbinganModel;
use App\Models\ProgresBimbinganModel;
use App\Models\RiwayatBimbinganModel;
use App\Models\KomentarModel;
use DataTables;
use Auth;
use File;

class KonsulJudulController extends Controller
{
    public function index(Request $request)
    {
        /* Get data User Identitas */
        $identitas = Auth::user()->identitas_id;

        /* Get data DosPem */
        $pembimbing_id = DosPemModel::where('nim', $identitas)->first();

        /* Get data Tahun */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Get data Bimbingan */
        $bimbingan_id = BimbinganModel::where('pembimbing_kode', $pembimbing_id->kode_pembimbing)
            ->where('jenis_bimbingan', 'Judul')
            ->first();

        /* Get Kondisi Jika Data Kosong */
        if(empty($bimbingan_id)){
            $file_upload = "0";
            $status = "Belum Konsultasi";
            $komentar = "0";
            $kode = "0";
        } else {
            $file_upload = $bimbingan_id->file_upload;
            $status = $bimbingan_id->status_konsultasi;
            $komentar = $bimbingan_id->kode_komentar;
            $kode = $bimbingan_id->kode_bimbingan;
        }

        /* Get Komentar */
        if ($request->ajax()){
            $data = KomentarModel::latest()->where('bimbingan_kode', $kode)->where('bimbingan_jenis', 'Judul')->get();
            return DataTables::of($data)->toJson();
        }

        return view('mahasiswa.konsultasi.judul.index', compact('tahun_id','pembimbing_id','file_upload','status'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file_upload' => 'required|file|max:2048|mimes:pdf',
        ]);

        if($request->status_konsultasi == "Disetujui"){
            $data = "Konsultasi judul sudah selesai, silahkan lanjut untuk konsultasi berikutnya!";
            return response()->json(['resp' => 'error', 'data' => $data]);
        } else {
            /* Get data Tahun */
            $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

            if($request->status_konsultasi == "Belum Konsultasi"){
                $data = new ProgresBimbinganModel;
                $data->bimbingan_kode = "KB".substr($request->pembimbing_kode, 2);
                $data->tahun_ajaran_id = $tahun_id->id;
                $data->save();
            }

            if($request->status_konsultasi == "Belum"){
                $data = "GOBLOK!";
                return response()->json(['resp' => 'error', 'data' => $data]);
            }

            $file = $request->file('file_upload');
            $filename = time()."_".$file->getClientOriginalName();
            $file->move(public_path('dokumen/konsultasi/judul'), $filename);
            File::delete('dokumen/konsultasi/judul/'.$request->fileShow);

            // store
            $data2 = BimbinganModel::updateOrCreate(
                [
                    'pembimbing_kode' => $request->pembimbing_kode,
                    'jenis_bimbingan' => "Judul",
                ],
                [
                    'kode_bimbingan' => "KB".substr($request->pembimbing_kode, 2),
                    'tahun_ajaran_id' => $tahun_id->id,
                    'file_upload' => $filename,
                    'status_konsultasi' => "Belum Disetujui",
                    'status_pesan' => "0"
                ]
            );

            $data3 = new RiwayatBimbinganModel;
            $data3->bimbingan_kode = "KB".substr($request->pembimbing_kode, 2);
            $data3->bimbingan_jenis = "Judul";
            $data3->save();

            return response()->json(['resp' => 'success', 'data' => $data2]);
        }
    }

    public function storeKomen(Request $request)
    {
        /* Get data User Identitas */
        $identitas = Auth::user();

        /* Get data DosPem */
        $pembimbing_id = DosPemModel::where('nim', $identitas->identitas_id)->first();

        /* Get data Bimbingan */
        $bimbingan_id = BimbinganModel::where('pembimbing_kode', $pembimbing_id->kode_pembimbing)
            ->where('jenis_bimbingan', 'Judul')
            ->first();

        if(empty($bimbingan_id)){
            $data = "Error!! Lakukan konsultasi terlebih dahulu ..";
            return response()->json(['resp' => 'error', 'data' => $data]);
        }

        $request->validate([
            'komentar' => 'required',
        ]);

        $data = new KomentarModel;
        $data->bimbingan_kode = $bimbingan_id->kode_bimbingan;
        $data->bimbingan_jenis = $bimbingan_id->jenis_bimbingan;
        $data->nama = $identitas->name;
        $data->komentar = $request->komentar;
        $data->save();

        return response()->json(['resp' => 'success', 'data' => $data]);
    }
}
