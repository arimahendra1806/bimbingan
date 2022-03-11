<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProgresBimbinganModel;

class BimbinganModel extends Model
{
    use HasFactory;
    protected $table = "bimbingan";
    protected $fillable = ["id","kode_bimbingan","pembimbing_kode","tahun_ajaran_id","file_upload","link_video","jenis_bimbingan","status_konsultasi","status_pesan"];

    public function progres()
    {
        return $this->belongsTo(ProgresBimbinganModel::class,'kode_bimbingan','bimbingan_kode');
    }

    // public function bimbingan()
    // {
    //     return $this->belongsTo(BimbinganModel::class,'kode_pembimbing','pembimbing_kode');
    // }
}
