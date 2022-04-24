<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotifikasiModel;
use DataTables, Auth;

class TopbarController extends Controller
{
    public function informasi(Request $request){
        /* Ambil data user login */
        $user_id = Auth::user()->id;

        /* Ambil data count notifikasi */
        $data = NotifikasiModel::where('kepada', $user_id)->where('status', 'Belum Dibaca')->count('id');

        /* Return data count notifikasi */
        return response()->json($data);
    }

    public function informasiPengumuman(Request $request){
        /* Ambil data user login */
        $user_id = Auth::user()->id;

        /* Ambil data count notifikasi sesuai parameter */
        $data = NotifikasiModel::where('jenis', 'Pengumuman')
            ->where('kepada', $user_id)
            ->where('status', 'Belum Dibaca')->count('id');

        /* Return data count notifikasi */
        return response()->json($data);
    }

    public function informasiPeringatan(Request $request){
        /* Ambil data user login */
        $user_id = Auth::user()->id;

        /* Ambil data count notifikasi sesuai parameter */
        $data = NotifikasiModel::where('jenis', 'Peringatan')
            ->where('kepada', $user_id)
            ->where('status', 'Belum Dibaca')->count('id');

        /* Return data count notifikasi */
        return response()->json($data);
    }

    public function readAll(Request $request){
        /* Ambil data user login */
        $user_id = Auth::user()->id;

        /* Update status notifikasi */
        $data = NotifikasiModel::where('kepada', $user_id)->update(['status' => 'Dibaca']);

        /* Return */
        return response()->json();
    }
}
