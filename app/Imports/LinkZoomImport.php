<?php

namespace App\Imports;

use App\Models\LinkZoomModel;
use App\Models\DosenModel;
use App\Models\TahunAjaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class LinkZoomImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $tahun = TahunAjaran::where('status', 'Aktif')->first();

        $kode_dosen = DosenModel::where('nidn', $row[1])->first();
        if($kode_dosen){
            $id = $kode_dosen->id;
        } else {
            $id = "0";
        }

        return new LinkZoomModel([
            'dosen_id' => $id,
            'tahun_ajaran_id' => $tahun->id,
            'id_meeting' => $row[2],
            'passcode' => $row[3],
            'host_key' => $row[4],
            'link_zoom' => $row[5],
       ]);
    }
}
