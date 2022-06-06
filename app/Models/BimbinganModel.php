<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\KomentarModel;
use App\Models\ProgresBimbinganModel;
use App\Models\RiwayatBimbinganModel;
use App\Models\DosPemModel;

class BimbinganModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "bimbingan";
    protected $fillable = ["id","kode_bimbingan","pembimbing_kode","kode_peninjauan","tahun_ajaran_id","file_upload","link_video","jenis_bimbingan","status_konsultasi","status_pesan"];

    protected $cascadeDeletes = ['komentar','progres','riwayat'];
    protected $dates = ['deleted_at'];

    /* komentar */
    public function komentar()
    {
        return $this->belongsTo(KomentarModel::class,'kode_bimbingan','bimbingan_kode');
    }

    /* progres_bimbingan */
    public function progres()
    {
        return $this->belongsTo(ProgresBimbinganModel::class,'kode_bimbingan','bimbingan_kode');
    }

    /* riwayat_bimbingan */
    public function riwayat()
    {
        return $this->belongsTo(RiwayatBimbinganModel::class,'kode_bimbingan','bimbingan_kode');
    }

    public function tinjau()
    {
        return $this->belongsTo(RiwayatBimbinganModel::class,'kode_peninjauan','peninjauan_kode');
    }

    /* inisiasi dosen_pembimbing */
    public function pembimbing()
    {
        return $this->belongsTo(DosPemModel::class,'pembimbing_kode','kode_pembimbing');
    }
}
