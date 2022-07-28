<?php

namespace App\Exports;

use App\Models\DosPemModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class JudulExport implements FromCollection, WithMapping, WithHeadings
{
    protected $statusJudul;
    protected $tahun;

    function __construct($statusJudul, $tahun) {
        $this->statusJudul = $statusJudul;
        $this->tahun = $tahun;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $tahun_ajaran = $this->tahun;
        $st = $this->statusJudul;
        if ($st == '0') {
            return DosPemModel::with('tahun', 'dosen', 'mahasiswa', 'judul')->where('tahun_ajaran_id', $tahun_ajaran)->get();
        } else {
            return DosPemModel::with('judul','tahun', 'dosen', 'mahasiswa')
            ->whereHas('judul',  function($q) use($st)  {
                $q->where('status', $st);
            })
            ->where('tahun_ajaran_id', $tahun_ajaran)->latest()->get();
        }
    }

    public function map($model) : array {
        if ($model->judul->status == "Diterima"){
            $stats = "Diterima oleh Pembimbing";
        } elseif ($model->judul->status == "Selesai") {
            $stats = "Selesai Tugas Akhir";
        } else {
            $stats = $model->judul->status;
        }

        return [
            $model->tahun->tahun_ajaran,
            $model->dosen->nama_dosen,
            $model->mahasiswa->nama_mahasiswa,
            $model->judul->judul,
            $stats
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
