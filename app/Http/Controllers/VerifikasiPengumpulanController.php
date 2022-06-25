<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VerifikasiPengumpulanModel;
use App\Models\TahunAjaran;
use DataTables, Auth, File, Validator;

class VerifikasiPengumpulanController extends Controller
{
    public function indexPro(Request $request)
    {
        /* Ambil data mahasiswa login */
        $user = User::with('mahasiswa.verifikasi')->find(Auth::user()->id);

        if ($user->mahasiswa->verifikasi) {
            $cek_status = $user->mahasiswa->verifikasi->status . ' | ' . $user->mahasiswa->verifikasi->keterangan;
            $cek_file = $user->mahasiswa->verifikasi->nama_file;
        } else {
            $cek_status = '0';
            $cek_file = '0';
        }

        /* Return menuju view */
        return view('mahasiswa.pengumpulan-proposal.index', compact('cek_status','cek_file'));
    }

    public function storePro(Request $request)
    {
        /* Peraturan validasi  */
        $rules = [
            'file_upload' => ['required','file','max:2048','mimes:jpg,jpeg,png']
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'file_upload' => 'Lembar Pengumpulan',
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Ambil data mahasiswa login */
            $user = User::with('mahasiswa.verifikasi')->find(Auth::user()->id);
            /* Ambil data tahun ajaran */
            $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

            /* Jika request terdapat file */
            if ($request->hasFile('file_upload')){
                if($user->mahasiswa->verifikasi){
                    /* Hapus data file sebelumnya */
                    $path = public_path() . '/dokumen/pengumpulan/proposal/' . $user->mahasiswa->verifikasi->nama_file;
                    File::delete($path);
                }

                $file = $request->file('file_upload');
                $filename = time()."_".$file->getClientOriginalName();
                $file->move(public_path('dokumen/pengumpulan/proposal'), $filename);
            }

            $data = VerifikasiPengumpulanModel::updateOrCreate(
                [
                    'mahasiswa_id' => $user->mahasiswa->id,
                    'tahun_ajaran_id' => $tahun_id->id],
                [
                    'jenis' => 'proposal',
                    'nama_file' => $filename,
                    'status' => 'Sedang Diproses',
                    'keterangan' => 'Admin Prodi sedang memverifikasi lembar pengumpulan Anda.'
                ]
            );

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Menambahkan Data!", 'resp' => $data]);
        }
    }
}
