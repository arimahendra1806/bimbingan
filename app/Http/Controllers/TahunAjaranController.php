<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use DataTables, Validator;

class TahunAjaranController extends Controller
{
    public function index(Request $request)
    {
        /* Ambil data tabel tahun ajaran */
        if ($request->ajax()){
            $data = TahunAjaran::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-info" id="btnShow" data-toggle="tooltip" title="Detail Data" data-id="'.$model->id.'"><i class="fas fa-clipboard-list"></i></a>
                    <a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>
                    <a id="btnDelete" data-id="'.$model->id.'" class="btn btn-danger delete-user" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-prescription-bottle"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        /* Return menuju view */
        return view('koordinator.kelola-tahun-ajaran.index');
    }

    public function store(Request $request)
    {
        /* Peraturan validasi  */
        $rules = [
            'tahun_ajaran_add' => ['required','unique:tahun_ajaran,tahun_ajaran'],
            'tahun_status_add' => ['required']
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'tahun_ajaran_add' => 'Tahun Ajaran',
            'tahun_status_add' => 'Status Tahun Ajaran'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Insert tahun ajaran */
            $data = new TahunAjaran;
            $data->tahun_ajaran = $request->tahun_ajaran_add;
            $data->status = $request->tahun_status_add;
            $data->save();

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Menambahkan Data!"]);
        }
    }

    public function show($tahun_ajaran)
    {
        /* Ambil data tahun ajaran sesuai parameter */
        $data = TahunAjaran::find($tahun_ajaran);

        /* Return json data tahun ajaran */
        return response()->json($data);
    }

    public function update(Request $request, $tahun_ajaran)
    {
        /* Ambil data dosen sesuai parameter */
        $init = TahunAjaran::where('id', $tahun_ajaran)->first();

        /* Kondisi data nidn tidak sama, maka validasi berikut */
        if($init->tahun_ajaran == $request->tahun_ajaran_edit) {
            /* Peraturan validasi  */
            $rules = [
                'tahun_status_edit' => ['required']
            ];
        } else {
            /* Peraturan validasi  */
            $rules = [
                'tahun_ajaran_edit' => ['required','unique:tahun_ajaran,tahun_ajaran'],
                'tahun_status_edit' => ['required']
            ];
        }

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'tahun_ajaran_edit' => 'Tahun Ajaran',
            'tahun_status_edit' => 'Status Tahun Ajaran'
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Update tahun ajaran */
            $data = TahunAjaran::where('id', $tahun_ajaran)->first();
            $data->tahun_ajaran = $request->tahun_ajaran_edit;
            $data->status = $request->tahun_status_edit;
            $data->save();

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Memperbarui Data!"]);
        }
    }

    public function destroy($tahun_ajaran)
    {
        /* Hapus data tahun ajaran sesuai parameter */
        $data = TahunAjaran::find($tahun_ajaran)->

        /* Hapus data tahun ajaran */
        $data->forceDelete();

        /* Return json berhasil */
        return response()->json(['msg' => "Berhasil Menghapus Data!"]);
    }
}
