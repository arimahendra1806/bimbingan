<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgresBimbinganModel;
use App\Models\DosenModel;
use App\Models\DosPemModel;
use App\Models\BimbinganModel;
use DataTables, Validator;

class ProgresKonsultasiController extends Controller
{
    public function index(Request $request){
        /* Ambil data dosen */
        $dosen_id = DosenModel::all()->sortBy('nama_dosen');

        /* Ambil data tabel progres bimbingan */
        if($request->ajax()){
            $data = ProgresBimbinganModel::get()->load('bimbingan.pembimbing.mahasiswa.judul.anggota');
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('total', function($model){
                    $total = $model->judul + $model->proposal_bab1 + $model->proposal_bab2 +
                        $model->proposal_bab3 + $model->proposal_bab4 + $model->laporan_bab1 +
                        $model->laporan_bab2 + $model->laporan_bab3 + $model->laporan_bab4 +
                        $model->laporan_bab5 + $model->laporan_bab6 + $model->program;
                    return $total;
                })
                ->rawColumns(['total'])
                ->toJson();
        }

        /* Return menuju view */
        return view('partial.progress-konsultasi.index', compact('dosen_id'));
    }

    public function show(Request $request, $id, $urutan) {
        /* Ambil data tabel dospem sesuai parameter */
        $dospem = DosPemModel::where('dosen_id', $id)->get();
        /* Membuat array data kode pembimbing dari tabel dospem */
        $arr_kp = $dospem->pluck('kode_pembimbing')->toArray();
        /* Ambil data tabel bimbingan sesuai array kp */
        $bimbingan = BimbinganModel::whereIn('pembimbing_kode', $arr_kp)->groupBy('kode_bimbingan');
        /* Membuat array data kode bimbingan dari tabel bimbingan */
        $arr_kb = $bimbingan->pluck('kode_bimbingan')->toArray();

        /* Jika paramter sama dengan semua */
        if($id == "Semua"){
            /* Ambil data tabel progres bimbingan */
            if($request->ajax()){
                $data = ProgresBimbinganModel::get()->load('bimbingan.pembimbing.mahasiswa.judul.anggota');
                return DataTables::of($data)->addIndexColumn()
                    ->addColumn('total', function($model){
                        $total = $model->judul + $model->proposal_bab1 + $model->proposal_bab2 +
                            $model->proposal_bab3 + $model->proposal_bab4 + $model->laporan_bab1 +
                            $model->laporan_bab2 + $model->laporan_bab3 + $model->laporan_bab4 +
                            $model->laporan_bab5 + $model->laporan_bab6 + $model->program;
                        return $total;
                    })
                    ->rawColumns(['total'])
                    ->toJson();
            }
        } else {
            /* Ambil data tabel progres bimbingan dengan parameter array kb*/
            if($request->ajax()){
                $data = ProgresBimbinganModel::whereIn('bimbingan_kode', $arr_kb)->get()->load('bimbingan.pembimbing.mahasiswa.judul.anggota');
                return DataTables::of($data)->addIndexColumn()
                    ->addColumn('total', function($model){
                        $total = $model->judul + $model->proposal_bab1 + $model->proposal_bab2 +
                            $model->proposal_bab3 + $model->proposal_bab4 + $model->laporan_bab1 +
                            $model->laporan_bab2 + $model->laporan_bab3 + $model->laporan_bab4 +
                            $model->laporan_bab5 + $model->laporan_bab6 + $model->program;
                        return $total;
                    })
                    ->rawColumns(['total'])
                    ->toJson();
            }
        }
    }
}
