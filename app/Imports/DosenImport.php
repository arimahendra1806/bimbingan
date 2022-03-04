<?php

namespace App\Imports;

use App\Models\DosenModel;
use App\Models\User;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DosenImport implements WithStartRow, ToCollection
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

    public function collection(Collection $rows)
    {
        $tahun = TahunAjaran::where('status', 'Aktif')->first();

        foreach ($rows as $row)
        {
            DosenModel::create([
                'nidn' => $row[1],
                'nama_dosen' => $row[2],
                'email' => $row[3],
                'no_telepon' => $row[4],
                'alamat' => $row[5],
            ]);

            User::create([
                'identitas_id' => $row[1],
                'tahun_ajaran_id' => $tahun->id,
                'name' => $row[2],
                'role' => "dosen",
                'email' => $row[1]."@bimbingan.id",
                'password' => Hash::make($row[1]),
            ]);
        }
    }
}
