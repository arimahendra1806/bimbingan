<?php

namespace App\Imports;

use App\Models\AdminModel;
use App\Models\User;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class AdminImport implements WithStartRow, ToCollection
{
    /**
    * @param Collection $collection
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
            if($row->filter()->isNotEmpty()){
                $data = User::create([
                    'username' => $row[1],
                    'tahun_ajaran_id' => $tahun->id,
                    'name' => $row[2],
                    'role' => "admin",
                    'password' => Hash::make($row[1]),
                ]);

                AdminModel::create([
                    'users_id' => $data->id,
                    'nip' => $row[1],
                    'nama_admin' => $row[2],
                    'email' => $row[3],
                    'no_telepon' => $row[4],
                    'alamat' => $row[5],
                ]);
            }
        }
    }
}
