<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DosenModel;

class DosenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dosen = new DosenModel;
        $dosen->users_id = "1";
        $dosen->nidn = "1780123499";
        $dosen->nama_dosen = "Budi Gunawan";
        $dosen->alamat = "Jln. Helena No.88 Kota Kediri";
        $dosen->email = "budigunawan@gmail.com";
        $dosen->no_telepon = "81234567890";
        $dosen->save();
    }
}
