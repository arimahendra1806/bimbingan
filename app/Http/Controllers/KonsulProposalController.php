<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\DosPemModel;
use App\Models\TahunAjaran;
use App\Models\DosPemMateriModel;
use App\Models\BimbinganModel;
use App\Models\RiwayatBimbinganModel;
use App\Models\KomentarModel;
use DataTables;
use Auth;
use File;

class KonsulProposalController extends Controller
{
    public function indexJudul(Request $request)
    {
        /* Get data User Identitas */
        $identitas = Auth::user()->identitas_id;

        /* Get data DosPem */
        $pembimbing_id = DosPemModel::where('nim', $identitas)->first();

        /* Get data Tahun */
        $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

        /* Get data Bimbingan */
        $bimbingan_id = BimbinganModel::where('pembimbing_kode', $pembimbing_id->kode_pembimbing)
            ->where('jenis_konsultasi', 'Proposal')
            ->where('bab_konsultasi', 'Judul')
            ->first();

        /* Get Kondisi Jika Data Kosong */
        if(empty($bimbingan_id)){
            $file_upload = "0";
            $status = "Belum Konsultasi";
            $komentar = "0";
        } else {
            $file_upload = $bimbingan_id->file_upload;
            $status = $bimbingan_id->status;
            $komentar = $bimbingan_id->kode_komentar;
        }

        /* Get Komentar */
        if ($request->ajax()){
            $data = KomentarModel::latest()->where('komentar_kode', $komentar)->get();
            return DataTables::of($data)->toJson();
        }

        return view('mahasiswa.konsultasi.proposal.judul.index', compact('tahun_id','pembimbing_id','file_upload','status'));
    }

    public function storeJudul(Request $request)
    {
        $request->validate([
            'file_upload' => 'required|file|max:2048|mimes:pdf',
        ]);

        if($request->status_konsultasi == "Diterima"){
            $data = "Konsultasi judul proposal sudah selesai, silahkan lanjut untuk konsultasi berikutnya!";
            return response()->json(['resp' => 'error', 'data' => $data]);
        } else {
            /* Get data Tahun */
            $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

            /* Get random kode */
            $randomString = Str::random(20);

            $file = $request->file('file_upload');
            $filename = time()."_".$file->getClientOriginalName();
            $file->move(public_path('dokumen/konsultasi/proposal/judul'), $filename);
            File::delete('dokumen/konsultasi/proposal/judul/'.$request->fileShow);

            // store
            $data = BimbinganModel::updateOrCreate(
                [
                    'pembimbing_kode' => $request->pembimbing_kode,
                    'jenis_konsultasi' => "Proposal",
                    'bab_konsultasi' => "Judul",
                ],
                [
                    'kode_bimbingan' => "KB".substr($request->pembimbing_kode, 2),
                    'kode_komentar' => $randomString,
                    'tahun_ajaran_id' => $tahun_id->id,
                    'file_upload' => $filename,
                    'status' => "Belum Diterima"
                ]
            );

            $data2 = new RiwayatBimbinganModel;
            $data2->bimbingan_kode = "KB".substr($request->pembimbing_kode, 2);
            $data2->konsultasi_jenis = "Proposal";
            $data2->konsultasi_bab = "Judul";
            $data2->save();

            return response()->json(['resp' => 'success', 'data' => $data]);
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
            ->where('jenis_konsultasi', 'Proposal')
            ->where('bab_konsultasi', 'Judul')
            ->first();

        if(empty($bimbingan_id)){
            $data = "Error!! Lakukan konsultasi terlebih dahulu ..";
            return response()->json(['resp' => 'error', 'data' => $data]);
        }

        $request->validate([
            'komentar' => 'required',
        ]);

        $data = new KomentarModel;
        $data->komentar_kode = $bimbingan_id->kode_komentar;
        $data->nama = $identitas->name;
        $data->komentar = $request->komentar;
        $data->save();

        return response()->json(['resp' => 'success', 'data' => $data]);
    }
}
