<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\LinkZoomModel;
use App\Models\TahunAjaran;
use App\Models\DosenModel;
use App\Imports\LinkZoomImport;
use DataTables, Validator;

class LinkZoomController extends Controller
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
        $tahun_aktif = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data dosen */
        $dosen_id = DosenModel::all()->sortBy('nama_dosen');

        /* Ambil data tabel link_zoom */
        if ($request->ajax()){
            $data = LinkZoomModel::latest()->get()->load('tahun','dosen');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-info" id="btnShow" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>
                    <a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>
                    <a id="btnDelete" data-id="'.$model->id.'" class="btn btn-danger" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-prescription-bottle"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        /* Return menuju view */
        return view('koordinator.kelola-link-zoom.index', compact('tahun_id', 'dosen_id', 'tahun_aktif'));
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
            'dosen_add' => ['required','numeric','unique:link_zoom,dosen_id'],
            'tahun_ajaran_id_add' => ['required'],
            'id_meeting_add' => ['required'],
            'passcode_add' => ['required'],
            'link_add' => ['required']
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'dosen_add' => 'Nama Dosen',
            'tahun_ajaran_id_add' => 'ID Tahun Ajaran',
            'id_meeting_add' => 'ID Meeting',
            'passcode_add' => 'Passcode',
            'link_add' => 'Link Zoom'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $tahun_id = TahunAjaran::where('status', 'Aktif')->first();

            /* Insert ke tabel link_zoom */
            $data = new LinkZoomModel;
            $data->dosen_id = $request->dosen_add;
            $data->tahun_ajaran_id = $tahun_id->id;
            $data->id_meeting = $request->id_meeting_add;
            $data->passcode = $request->passcode_add;
            $data->link_zoom = $request->link_add;
            $data->save();

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
    public function show($link_zoom)
    {
        /* Ambil data link_zoom sesuai parameter */
        $data = LinkZoomModel::find($link_zoom)->load('tahun','dosen');

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
    public function update(Request $request, $link_zoom)
    {
        /* Ambil data users sesuai parameter */
        $data = LinkZoomModel::where('id', $link_zoom)->first();

        /* Kondisi data username tidak sama, maka validasi berikut */
        if($data->dosen_id == $request->dosen_edit) {
            /* Peraturan validasi  */
            $rules = [
                'tahun_ajaran_id_edit' => ['required'],
                'id_meeting_edit' => ['required'],
                'passcode_edit' => ['required'],
                'link_edit' => ['required']
            ];
        } else {
            /* Peraturan validasi  */
            $rules = [
                'dosen_edit' => ['required','numeric','unique:link_zoom,dosen_id'],
                'tahun_ajaran_id_edit' => ['required'],
                'id_meeting_edit' => ['required'],
                'passcode_edit' => ['required'],
                'link_edit' => ['required']
            ];
        }

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'dosen_edit' => 'Username',
            'tahun_ajaran_id_edit' => 'ID Tahun Ajaran',
            'id_meeting_edit' => 'ID Meeting',
            'passcode_edit' => 'Passcode',
            'link_edit' => 'Link Zoom'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Update tabel link zoom */
            $data->dosen_id = $request->dosen_edit;
            $data->tahun_ajaran_id = $request->tahun_ajaran_id_edit;
            $data->id_meeting = $request->id_meeting_edit;
            $data->passcode = $request->passcode_edit;
            $data->link_zoom = $request->link_edit;
            $data->save();

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
    public function destroy($link_zoom)
    {
        /* Ambil data users sesuai parameter */
        $data = LinkZoomModel::find($link_zoom);

        /* Hapus data link_zoom */
        $data->forceDelete();

        /* Return json berhasil */
        return response()->json(['msg' => "Berhasil Menghapus Data!"]);
    }

    public function import(Request $request)
    {
        /* Peraturan validasi  */
        $rules = [
            'file_import' => ['required','file','max:2048','mimes:csv,xlsx,xls']
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'file_import' => 'File Data Import'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Impor data link_zoom*/
            $file = $request->file('file_import');
            Excel::import(new LinkZoomImport, $file);

            /* Return json berhasil */
            return response()->json(['msg' => "Berhasil Mengimpor Data!"]);
        }
    }
}
