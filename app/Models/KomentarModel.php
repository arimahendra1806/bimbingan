<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomentarModel extends Model
{
    use HasFactory;
    protected $table = "komentar";
    protected $fillable = ["id","bimbingan_kode","bimbingan_jenis","nama","komentar","waktu_komentar"];
}
