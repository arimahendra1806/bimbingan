<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatBimbinganModel extends Model
{
    use HasFactory;
    protected $table = "riwayat_bimbingan";
    protected $fillable = ["id","bimbingan_kode","bimbingan_jenis","waktu_bimbingan"];
}
