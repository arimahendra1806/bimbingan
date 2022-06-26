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
        $user = User::with(['mahasiswa.verifikasi' => function($q){
            $q->where('jenis', 'proposal');
        }])->find(Auth::user()->id);

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
                    'tahun_ajaran_id' => $tahun_id->id,
                    'jenis' => 'proposal'],
                [
                    'nama_file' => $filename,
                    'status' => 'Sedang Diproses',
                    'keterangan' => 'Admin Prodi sedang memverifikasi lembar pengumpulan Anda.'
                ]
            );

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Menambahkan Data!", 'resp' => $data]);
        }
    }

    public function indexLap(Request $request)
    {
        /* Ambil data mahasiswa login */
        $user = User::with(['mahasiswa.verifikasi' => function($q){
            $q->where('jenis', 'laporan');
        }])->find(Auth::user()->id);

        if ($user->mahasiswa->verifikasi) {
            $cek_status = $user->mahasiswa->verifikasi->status . ' | ' . $user->mahasiswa->verifikasi->keterangan;
            $cek_file = $user->mahasiswa->verifikasi->nama_file;
        } else {
            $cek_status = '0';
            $cek_file = '0';
        }

        /* Return menuju view */
        return view('mahasiswa.pengumpulan-laporan.index', compact('cek_status','cek_file'));
    }

    public function storeLap(Request $request)
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
                    $path = public_path() . '/dokumen/pengumpulan/laporan/' . $user->mahasiswa->verifikasi->nama_file;
                    File::delete($path);
                }

                $file = $request->file('file_upload');
                $filename = time()."_".$file->getClientOriginalName();
                $file->move(public_path('dokumen/pengumpulan/laporan'), $filename);
            }

            $data = VerifikasiPengumpulanModel::updateOrCreate(
                [
                    'mahasiswa_id' => $user->mahasiswa->id,
                    'tahun_ajaran_id' => $tahun_id->id,
                    'jenis' => 'laporan'],
                [
                    'nama_file' => $filename,
                    'status' => 'Sedang Diproses',
                    'keterangan' => 'Admin Prodi sedang memverifikasi lembar pengumpulan Anda.'
                ]
            );

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Menambahkan Data!", 'resp' => $data]);
        }
    }

    public function indexAdmPro(Request $request) {

        /* Ambil data tabel link_zoom */
        if ($request->ajax()){
            $data = VerifikasiPengumpulanModel::where('jenis', 'proposal')
                ->latest()->get()->load('mhs','tahun');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-secondary glightbox" id="btnShow" data-toggle="tooltip" title="Detail File" data-id="'.$model->nama_file.'"><i class="fas fa-eye"></i></a>
                    <a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>';
                    return $btn;
                })
                ->addColumn('waktu', function($model){
                    $waktu = \Carbon\Carbon::parse($model->created_at)->isoFormat('D MMMM Y / HH:mm:ss');
                    return $waktu;
                })
                ->rawColumns(['action','waktu'])
                ->toJson();
        }

        /* Return menuju view */
        return view('admin.verifikasi-proposal.index');
    }

    public function indexAdmLap(Request $request) {

        /* Ambil data tabel link_zoom */
        if ($request->ajax()){
            $data = VerifikasiPengumpulanModel::where('jenis', 'laporan')
                ->latest()->get()->load('mhs','tahun');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-secondary glightbox" id="btnShow" data-toggle="tooltip" title="Detail File" data-id="'.$model->nama_file.'"><i class="fas fa-eye"></i></a>
                    <a class="btn btn-success" id="btnEdit" data-toggle="tooltip" title="Perbarui Data" data-id="'.$model->id.'"><i class="fas fa-edit"></i></a>';
                    return $btn;
                })
                ->addColumn('waktu', function($model){
                    $waktu = \Carbon\Carbon::parse($model->created_at)->isoFormat('D MMMM Y / HH:mm:ss');
                    return $waktu;
                })
                ->rawColumns(['action','waktu'])
                ->toJson();
        }

        /* Return menuju view */
        return view('admin.verifikasi-laporan.index');
    }


    public function storeAdm(Request $request, $id)
    {
        /* Peraturan validasi  */
        $rules = [
            'status' => ['required'],
            'keterangan' => ['required'],
        ];

        /* Pesan validasi */
        $messages = [];

        /* Nama kolom validasi */
        $attributes = [
            'status' => 'Status Verifikasi',
            'ketarangan' => 'Keterangan',
        ];

        /* Validasi input */
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        /* Kondisi jika validasi gagal */
        if(!$validator->passes()){
            /* Return json gagal */
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            /* Ambil data mahasiswa login */
            $data = VerifikasiPengumpulanModel::find($id);
            $data->status = $request->status;
            $data->keterangan = $request->keterangan;
            $data->save();

            /* Return json berhasil */
            return response()->json(['status' => 1, 'msg' => "Berhasil Memperbarui Data!"]);
        }
    }

    public function show($id){
        /* Ambil data materi dosen sesuai parameter */
        $data = VerifikasiPengumpulanModel::find($id);

        /* Return json data materi tahunan */
        return response()->json($data);
    }

    public function daftarPro(Request $request) {
        $tahun = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data tabel link_zoom */
        if ($request->ajax()){
            $data = VerifikasiPengumpulanModel::where('jenis', 'proposal')
                ->where('tahun_ajaran_id', $tahun->id)
                ->latest()->get()->load('mhs','tahun');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-secondary glightbox" id="btnShow" data-toggle="tooltip" title="Detail File" data-id="'.$model->nama_file.'"><i class="fas fa-eye"></i></a>';
                    return $btn;
                })
                ->addColumn('waktu', function($model){
                    $waktu = \Carbon\Carbon::parse($model->created_at)->isoFormat('D MMMM Y / HH:mm:ss');
                    return $waktu;
                })
                ->rawColumns(['action','waktu'])
                ->toJson();
        }

        /* Return menuju view */
        return view('partial.daftar-pengumpulan.proposal.index');
    }

    public function daftarLap(Request $request) {
        $tahun = TahunAjaran::where('status', 'Aktif')->first();

        /* Ambil data tabel link_zoom */
        if ($request->ajax()){
            $data = VerifikasiPengumpulanModel::where('jenis', 'laporan')
                ->where('tahun_ajaran_id', $tahun->id)
                ->latest()->get()->load('mhs','tahun');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($model){
                    $btn = '<a class="btn btn-secondary glightbox" id="btnShow" data-toggle="tooltip" title="Detail File" data-id="'.$model->nama_file.'"><i class="fas fa-eye"></i></a>';
                    return $btn;
                })
                ->addColumn('waktu', function($model){
                    $waktu = \Carbon\Carbon::parse($model->created_at)->isoFormat('D MMMM Y / HH:mm:ss');
                    return $waktu;
                })
                ->rawColumns(['action','waktu'])
                ->toJson();
        }

        /* Return menuju view */
        return view('partial.daftar-pengumpulan.laporan.index');
    }
}
