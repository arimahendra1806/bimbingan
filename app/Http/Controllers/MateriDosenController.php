<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\DosPemMateriModel;
use App\Models\User;
use App\Models\FileDosPemMateriModel;
use DataTables, Validator, File, Auth;

class MateriDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* Ambil data tahun_ajaran */
        $tahun_id = TahunAjaran::all()->sortByDesc('tahun_ajaran');
        $th_aktif = TahunAjaran::where('status', 'Aktif')->first();

        $user = User::with('dosen')->find(Auth::user()->id);

        /* Ambil data tabel materi dosen */
        if ($request->ajax()){
            $data = DosPemMateriModel::where('dosen_id', $user->dosen->id)
                ->latest()->get()->load('tahun');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-info" id="btnShow" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>
                    <a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>
                    <a id="btnDelete" data-id="'.$model->id.'" class="btn btn-danger" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-prescription-bottle"></i></a>';
                    return $btn;
                })
                ->addColumn('jml_file', function($model){
                    $data = FileDosPemMateriModel::where('materi_dospem_id', $model->id)->count('id');
                    return $data;
                })
                ->rawColumns(['action','jml_file'])
                ->toJson();
        }

        /* Return menuju view */
        return view('dosen.kelola-materi-dosen.index', compact('tahun_id', 'th_aktif'));
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
        /* Peraturan validasi  */
        $rules = [
            'tahun_ajaran_id_add' => ['required'],
            'file_materi_add' => ['required'],
            'file_materi_add.*' => ['file','max:20480','mimes:pdf,docx,jpg,jpeg,png,xlxs,ppt,txt'],
            'jenis_materi_add' => ['required'],
            'keterangan_add' => ['required']
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'tahun_ajaran_id_add' => 'Tahun Ajaran',
            'file_materi_add' => 'File Materi',
            'file_materi_add.*' => 'File Materi',
            'jenis_materi_add' => 'Jenis Materi',
            'keterangan_add' => 'Keterangan'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Ambil data dosen login */
            $user = User::with('dosen')->find(Auth::user()->id);
            $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

            /* Insert materi dosen */
            $data = new DosPemMateriModel;
            $data->dosen_id = $user->dosen->id;
            $data->tahun_ajaran_id = $tahun_id->id;
            $data->jenis_materi = $request->jenis_materi_add;
            $data->keterangan = $request->keterangan_add;
            $data->save();

            /* Jika request terdapat file */
            if ($request->hasFile('file_materi_add')){
                $file = $request->file('file_materi_add');
                foreach ($file as $key => $value) {
                    $filename = time()."_".$value->getClientOriginalName();
                    $value->move(public_path('dokumen/pembimbing-materi'), $filename);

                    $data2 = new FileDosPemMateriModel;
                    $data2->materi_dospem_id = $data->id;
                    $data2->nama_file = $filename;
                    $data2->save();
                }
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
    public function show($materi_dosen)
    {
        /* Ambil data materi dosen sesuai parameter */
        $data = DosPemMateriModel::find($materi_dosen)->load('tahun');

        /* Return json data materi tahunan */
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
    public function update(Request $request, $materi_dosen)
    {
        /* Ambil data request file materi */
        $init = $request->file_materi_edit;

        /* Kondisi init jika kosong, maka validasi berikut */
        if (!$init) {
            /* Peraturan validasi  */
            $rules = [
                'tahun_ajaran_id_edit' => ['required'],
                'jenis_materi_edit' => ['required'],
                'keterangan_edit' => ['required']
            ];
        } else {
            /* Peraturan validasi  */
            $rules = [
                'tahun_ajaran_id_edit' => ['required'],
                'file_materi_edit' => ['required'],
                'file_materi_edit.*' => ['file','max:20480','mimes:pdf,docx,jpg,jpeg,png,xlxs,ppt,txt'],
                'jenis_materi_edit' => ['required'],
                'keterangan_edit' => ['required']
            ];
        }

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'tahun_ajaran_id_edit' => 'Tahun Ajaran',
            'file_materi_edit' => 'File Materi',
            'file_materi_edit.*' => 'File Materi',
            'jenis_materi_edit' => 'Jenis Materi',
            'keterangan_edit' => 'Keterangan'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Update materi tahunan */
            $data = DosPemMateriModel::where('id', $materi_dosen)->first();
            $data->tahun_ajaran_id = $request->tahun_ajaran_id_edit;
            $data->jenis_materi = $request->jenis_materi_edit;
            $data->keterangan = $request->keterangan_edit;
            $data->save();

            /* Jika request terdapat file */
            if ($request->hasFile('file_materi_edit')){
                $file = $request->file('file_materi_edit');
                foreach ($file as $key => $value) {
                    $filename = time()."_".$value->getClientOriginalName();
                    $value->move(public_path('dokumen/pembimbing-materi'), $filename);

                    $data2 = new FileDosPemMateriModel;
                    $data2->materi_dospem_id = $data->id;
                    $data2->nama_file = $filename;
                    $data2->save();
                }
            }

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
    public function destroy($materi_dosen)
    {
        /* Ambil data materi tahunan sesuai parameter */
        $data = DosPemMateriModel::with('file')->find($materi_dosen);

        /* Hapus data file public */
        $arr_in = $data->file->pluck('nama_file')->toArray();
        foreach ($arr_in as $key => $value) {
            $path = public_path() . '/dokumen/pembimbing-materi/' . $value;
            File::delete($path);
        }

        /* Hapus data materi tahunan */
        $data->forceDelete();

        /* Return json berhasil */
        return response()->json(['msg' => "Berhasil Menghapus Data!"]);
    }

    public function tEdit(Request $request, $id) {
        if ($request->ajax()){
            $data = FileDosPemMateriModel::where('materi_dospem_id', $id)->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-secondary" id="tBtnDownload" data-toggle="tooltip" title="Download File" data-id="'.$model->id.'" href="/dokumen/pembimbing-materi/'.$model->nama_file.'" download><i class="fas fa-download"></i></a>
                    <a class="btn btn-danger" id="tBtnDelete" data-toggle="tooltip" title="Hapus File" data-id="'.$model->id.'"><i class="fas fa-prescription-bottle"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
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

    public function tDelete($id)
    {
        /* Ambil data materi tahunan sesuai parameter */
        $data = FileDosPemMateriModel::find($id);

        /* Hapus data file public */
        $path = public_path() . '/dokumen/pembimbing-materi/' . $data->nama_file;
        File::delete($path);

        /* Hapus data materi tahunan */
        $data->forceDelete();

        /* Return json berhasil */
        return response()->json(['msg' => "Berhasil Menghapus File!"]);
    }
}
