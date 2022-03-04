<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TahunAjaran;

class PengajuanJudulModel extends Model
{
    use HasFactory;
    protected $table = "pengajuan_judul";
    protected $fillable = ["id","nim","tahun_ajaran_id","judul","studi_kasus","pengerjaan","nim_anggota","status"];

    public function tahun()
    {
        return $this->belongsTo(TahunAjaran::class,'tahun_ajaran_id','id');
    }
}
