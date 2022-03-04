<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TahunAjaran;

class MahasiswaModel extends Model
{
    use HasFactory;

    protected $table = "mahasiswa";
    protected $fillable = ["id", "nim", "tahun_ajaran_id", "nama_mahasiswa", "alamat", "email", "no_telepon"];

    public function tahun()
    {
        return $this->belongsTo(TahunAjaran::class,'tahun_ajaran_id','id');
    }
}
