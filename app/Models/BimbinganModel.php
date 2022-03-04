<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BimbinganModel extends Model
{
    use HasFactory;
    protected $table = "bimbingan";
    protected $fillable = ["id","kode_bimbingan","kode_komentar","pembimbing_kode","tahun_ajaran_id","file_upload","link_video","jenis_konsultasi","bab_konsultasi","status"];
}
