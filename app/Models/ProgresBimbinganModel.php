<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\BimbinganModel;

class ProgresBimbinganModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "progres_bimbingan";
    protected $fillable = ["id","bimbingan_kode","tahun_ajaran_id","judul","proposalBab1","proposalBab2","proposalBab3","proposalBab4","laporanBab1","laporanBab2","laporanBab3","laporanBab4","laporanBab5","laporanBab6","program"];

    protected $cascadeDeletes = [];
    protected $dates = ['deleted_at'];

    /* progres_bimbingan */
    public function bimbingan()
    {
        return $this->belongsTo(BimbinganModel::class,'bimbingan_kode','kode_bimbingan');
    }
}
