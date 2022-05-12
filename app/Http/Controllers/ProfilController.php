<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use Auth, Validator;

class ProfilController extends Controller
{
    public function index()
    {
        /* Ambil data mahasiswa login */
        $data = User::with('dosen','mahasiswa')->find(Auth::user()->id);

        return view('profile.index', compact('data'));
    }

    public function update(Request $request)
    {
        /* Peraturan validasi  */
        if($request->filled('password')) {
            /* Peraturan validasi  */
            $rules = [
                'nama' => ['required'],
                'email' => ['required','email'],
                'telepon' => ['required','string','min:10','max:13','regex:/^[1-9]{1}/'],
                'password' => ['required','min:8'],
                'confirm' => ['required','min:8']
            ];
        } else {
            /* Peraturan validasi  */
            $rules = [
                'nama' => ['required'],
                'email' => ['required','email'],
                'telepon' => ['required','string','min:10','max:13','regex:/^[1-9]{1}/'],
            ];
        }

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'nama' => 'Nama Anda',
            'email' => 'Email Anda',
            'telepon' => 'Nomor Telepon Anda',
            'password' => 'Password Baru Anda',
            'confirm' => 'Konfirmasi Password Baru Anda'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            if ($request->filled('password')) {
                if ($request->password != $request->confirm){
                    return response()->json(['status' => 0, 'error' => ['confirm' => ['Konfirmasi Password Baru Anda tidak sama']]]);
                }
            }

            if (!$request->filled('password') && $request->filled('confirm')) {
                return response()->json(['status' => 0, 'error' => ['password' => ['Password Baru Anda wajib diisi'], 'confirm' => ['Konfirmasi Password Baru Anda tidak valid']]]);
            }

            /* Update ke tabel User */
            $data = User::with('dosen','mahasiswa')->where('id', Auth::user()->id)->first();

            if($data->role == "koordinator" || $data->role == "kaprodi" || $data->role == "dosen") {
                $data->dosen->nama_dosen = $request->nama;
                $data->dosen->email = $request->email;
                $data->dosen->no_telepon = $request->telepon;
                $data->dosen->save();

                $renama = $data->dosen->nama_dosen;
                $reemail = $data->dosen->email;
                $retelepon = $data->dosen->no_telepon;
            } elseif($data->role == "mahasiswa") {
                $data->mahasiswa->nama_mahasiswa = $request->nama;
                $data->mahasiswa->email = $request->email;
                $data->mahasiswa->no_telepon = $request->telepon;
                $data->mahasiswa->save();

                $renama = $data->mahasiswa->nama_mahasiswa;
                $reemail = $data->mahasiswa->email;
                $retelepon = $data->mahasiswa->no_telepon;
            }

            if ($request->filled('password')) {
                $data->password = Hash::make($request->password);
                $data->save();
            }

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Memperbarui Data Profil!", 'nama' => $renama, 'email' => $reemail, 'telepon' => $retelepon]);
        }
    }
}
