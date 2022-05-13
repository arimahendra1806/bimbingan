<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\PengajuanJudulModel;
use App\Models\User;
use App\Models\DosPemModel;
use App\Models\TahunAjaran;

class MahasiswaModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "mahasiswa";
    protected $fillable = ["id", "users_id", "nim", "tahun_ajaran_id", "nama_mahasiswa", "alamat", "email", "no_telepon"];

    protected $cascadeDeletes = ['judul','anggota','user','dospem'];
    protected $dates = ['deleted_at'];

    /* pengajuan_judul */
    public function judul()
    {
        return $this->belongsTo(PengajuanJudulModel::class,'id','mahasiswa_id');
    }

    /* pengajuan_judul (anggota) */
    public function anggota()
    {
        return $this->belongsTo(PengajuanJudulModel::class,'id','id_anggota');
    }

    /* dosen_pembimbing */
    public function dospem()
    {
        return $this->belongsTo(DosPemModel::class,'id','mahasiswa_id');
    }

    /* inisiasi user */
    public function user()
    {
        return $this->belongsTo(User::class,'users_id','id');
    }

    /* inisiasi tahun */
    public function tahun()
    {
        return $this->belongsTo(TahunAjaran::class,'tahun_ajaran_id','id');
    }
}
