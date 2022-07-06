<?php

namespace App\Exports;

use App\Models\DosPemModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class JudulExport implements FromCollection, WithMapping, WithHeadings
{
    protected $tahun;

    function __construct($tahun) {
        $this->tahun = $tahun;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $tahun_ajaran = $this->tahun;
        return DosPemModel::with('tahun', 'dosen', 'mahasiswa', 'judul')->where('tahun_ajaran_id', $tahun_ajaran)->get();
    }

    public function map($model) : array {
        return [
            $model->tahun->tahun_ajaran,
            $model->dosen->nama_dosen,
            $model->mahasiswa->nama_mahasiswa,
            $model->judul->judul,
            $model->judul->status
        ] ;
    }

    public function headings() : array {
        return [
           'Tahun Ajaran',
           'Nama Dosen',
           'Nama Mahasiswa',
           'Judul Tugas Akhir',
           'Status Judul'
        ] ;
    }
}
