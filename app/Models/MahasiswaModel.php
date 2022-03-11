<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TahunAjaran;
use App\Models\User;


class MahasiswaModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "mahasiswa";
    protected $fillable = ["id", "users_id", "nim", "tahun_ajaran_id", "nama_mahasiswa", "alamat", "email", "no_telepon"];
    protected $delete = ['deleted_at'];

    public function tahun()
    {
        return $this->belongsTo(TahunAjaran::class,'tahun_ajaran_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'users_id','id');
    }
}
