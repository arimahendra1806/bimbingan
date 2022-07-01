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
        $dosen->nidn = "1731730001";
        $dosen->nama_dosen = "Budi Gunawan M.Kom";
        $dosen->alamat = "Jln. Helena No.88 Kota Kediri";
        $dosen->email = "budigunawan@gmail.com";
        $dosen->no_telepon = "81997858443";
        $dosen->save();
    }
}
