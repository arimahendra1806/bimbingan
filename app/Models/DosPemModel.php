<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TahunAjaran;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use App\Models\PengajuanJudulModel;
use App\Models\BimbinganModel;

class DosPemModel extends Model
{
    use HasFactory;
    protected $table = "dosen_pembimbing";
    protected $fillable = ["id","kode_pembimbing","nidn","nim","tahun_ajaran_id"];

    public function tahun()
    {
        return $this->belongsTo(TahunAjaran::class,'tahun_ajaran_id','id');
    }

    public function dosen()
    {
        return $this->belongsTo(DosenModel::class,'nidn','nidn');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class,'nim','nim');
    }

    public function judul()
    {
        return $this->belongsTo(PengajuanJudulModel::class,'nim','nim');
    }

    public function bimbingan()
    {
        return $this->belongsTo(BimbinganModel::class,'kode_pembimbing','pembimbing_kode');
    }
}
