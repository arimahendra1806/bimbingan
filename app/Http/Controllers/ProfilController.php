<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use App\Models\AdminModel;
use Auth, Validator;

class ProfilController extends Controller
{
    public function index()
    {
        /* Ambil data mahasiswa login */
        $data = User::with('dosen','mahasiswa','admin')->find(Auth::user()->id);

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
                'telepon' => ['required','numeric','digits_between:10,12','regex:/^[1-9]{1}/'],
                'password' => ['required','min:8'],
                'confirm' => ['required','min:8']
            ];
        } else {
            /* Peraturan validasi  */
            $rules = [
                'nama' => ['required'],
                'email' => ['required','email'],
                'telepon' => ['required','numeric','digits_between:10,12','regex:/^[1-9]{1}/'],
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
            $data = User::with('dosen','mahasiswa','admin')->where('id', Auth::user()->id)->first();

            $renama = $request->nama;
            $reemail = $request->email;
            $retelepon = $request->telepon;

            if($data->dosen) {
                $data->dosen->nama_dosen = $renama;
                $data->dosen->email = $reemail;
                $data->dosen->no_telepon = $retelepon;
                $data->dosen->save();

                $data->name = $renama;
                $data->save();
            }

            if($data->mahasiswa) {
                $data->mahasiswa->nama_mahasiswa = $renama;
                $data->mahasiswa->email = $reemail;
                $data->mahasiswa->no_telepon = $retelepon;
                $data->mahasiswa->save();

                $data->name = $renama;
                $data->save();
            }

            if($data->admin) {
                $data->admin->nama_admin = $renama;
                $data->admin->email = $reemail;
                $data->admin->no_telepon = $retelepon;
                $data->admin->save();

                $data->name = $renama;
                $data->save();
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
