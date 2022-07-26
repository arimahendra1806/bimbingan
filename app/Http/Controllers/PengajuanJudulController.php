<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\PengajuanJudulModel;
use App\Models\MahasiswaModel;
use App\Models\User;
use DataTables, Auth, Validator;

class PengajuanJudulController extends Controller
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

        /* Ambil data mahasiswa login */
        $user = User::with('mahasiswa')->find(Auth::user()->id);
        $mhs_id = $user->mahasiswa->id;

        /* Ambil data mahasiswa */
        $mahasiswa = MahasiswaModel::all()->sortBy('nama_mahasiswa');

        /* Ambil count pengajuan u/ kondisi */
        $count = PengajuanJudulModel::where('mahasiswa_id', $mhs_id)->count('id');

        /* Ambil data tabel pengajuan judul */
        if ($request->ajax()){
            $data = PengajuanJudulModel::where('tahun_ajaran_id', $tahun_id->id)->where('mahasiswa_id', $mhs_id)->get()->load('tahun');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        /* Return menuju view */
        return view('mahasiswa.pengajuan-judul.index', compact('tahun_id', 'user', 'count','mahasiswa'));
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
        /* Ambil data mahasiswa login */
        $user = User::with('mahasiswa')->find(Auth::user()->id);
        $mhs_id = $user->mahasiswa->id;

        if($request->pengerjaan_add == "Kelompok"){
            /* Peraturan validasi  */
            $rules = [
                'judul_add' => ['required'],
                'studi_kasus_add' => ['required'],
                'pengerjaan_add' => ['required'],
                'id_anggota_add' => ['required','not_in:Tidak Ada','not_in:'.$mhs_id,'unique:pengajuan_judul,id_anggota']
            ];
        } else {
            /* Peraturan validasi  */
            $rules = [
                'judul_add' => ['required'],
                'studi_kasus_add' => ['required'],
                'pengerjaan_add' => ['required'],
                'id_anggota_add' => ['required','in:Tidak Ada']
            ];
        }

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'judul_add' => 'Judul Yang Diajukan',
            'studi_kasus_add' => 'Studi Kasus',
            'pengerjaan_add' => 'Status Pengerjaan',
            'id_anggota_add' => 'Anggota Kelompok'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $get_kondisi = PengajuanJudulModel::where('mahasiswa_id', $mhs_id)->first();
            if ($get_kondisi) {
                $data = "Data Anda sudah ada!";
                return response()->json(['status' => 1, 'data' => $data]);
            } else {
                $get_kelompok = PengajuanJudulModel::with('mahasiswa')->where('id_anggota', $mhs_id)->first();
                if ($get_kelompok && $request->id_anggota_add != $get_kelompok->mahasiswa->id) {
                    return response()->json(['status' => 0, 'error' => ['id_anggota_add' => ['Anggota kelompok anda seharusnya ' . $get_kelompok->mahasiswa->nama_mahasiswa]]]);
                } else {
                    /* Ambil data tahun_ajaran */
                    $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

                    /* Insert ke tabel link_zoom */
                    $data = new PengajuanJudulModel;
                    $data->mahasiswa_id = $mhs_id;
                    $data->tahun_ajaran_id = $tahun_id->id;
                    $data->judul = $request->judul_add;
                    $data->studi_kasus = $request->studi_kasus_add;
                    $data->pengerjaan = $request->pengerjaan_add;

                    /* Jika request sama dengan tidak ada, maka berikut */
                    if($request->id_anggota_add != "Tidak Ada"){
                        $data->id_anggota = $request->id_anggota_add;
                    }

                    $data->status = "Diproses";
                    $data->save();

                    /* Return json berhasil */
                    return response()->json(['status' => 2, 'msg' => "Berhasil Menambahkan Data!"]);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pengajuan_judul)
    {
        /* Ambil data pengajuan judul sesuai parameter */
        $data = PengajuanJudulModel::with('anggota')->find($pengajuan_judul);

        /* Return json data link_zoom */
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
    public function update(Request $request, $pengajuan_judul)
    {
        /* Ambil data mahasiswa login */
        $user = User::with('mahasiswa')->find(Auth::user()->id);
        $mhs_id = $user->mahasiswa->id;

        /* Kondisi data pengerjaan sama, maka validasi berikut */
        if($request->pengerjaan_edit == "Kelompok") {
            /* Peraturan validasi  */
            $rules = [
                'judul_edit' => ['required'],
                'studi_kasus_edit' => ['required'],
                // 'pengerjaan_edit' => ['required'],
                // 'id_anggota_edit' => ['required','not_in:Tidak Ada','not_in:'.$mhs_id,'unique:pengajuan_judul,id_anggota']
            ];
        } else {
            /* Peraturan validasi  */
            $rules = [
                'judul_edit' => ['required'],
                'studi_kasus_edit' => ['required'],
                // 'pengerjaan_edit' => ['required'],
                // 'id_anggota_edit' => ['required','in:Tidak Ada']
            ];
        }

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'judul_edit' => 'Judul Yang Diajukan',
            'studi_kasus_edit' => 'Studi Kasus',
            // 'pengerjaan_edit' => 'Status Pengerjaan',
            // 'id_anggota_edit' => 'Anggota Kelompok'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Update tabel pengajuan judul */
            $data = PengajuanJudulModel::where('id', $pengajuan_judul)->first();

            if ($data->status == "Selesai") {
                $data = "Anda tidak dapat mengganti judul karena konsultasi sudah selesai.";
                return response()->json(['status' => 1, 'data' => $data]);
            } else {
                // $get_kelompok = PengajuanJudulModel::with('mahasiswa')->where('id_anggota', $mhs_id)->first();
                // if ($request->id_anggota_edit != $get_kelompok->mahasiswa->id) {
                //     return response()->json(['status' => 0, 'error' => ['id_anggota_edit' => ['Anggota kelompok anda seharusnya ' . $get_kelompok->mahasiswa->nama_mahasiswa]]]);
                // } else {
                    $data->judul = $request->judul_edit;
                    $data->studi_kasus = $request->studi_kasus_edit;
                    // $data->pengerjaan = $request->pengerjaan_edit;

                    // /* Jika request sama dengan tidak ada, maka berikut */
                    // if($request->id_anggota_edit != "Tidak Ada"){
                    //     $data->id_anggota = $request->id_anggota_edit;
                    // } else {
                    //     $data->id_anggota = 0;
                    // }

                    $data->save();
                // }

                /* Return json berhasil */
                return response()->json(['status' => 2, 'msg' => "Berhasil Memperbarui Data!"]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
