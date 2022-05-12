<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\PengajuanZoomAnggotaModel;
use App\Models\TahunAjaran;
use App\Models\DosPemModel;

class PengajuanZoomModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "pengajuan_jadwal_zoom";
    protected $fillable = ["id","kode_anggota_zoom","tahun_ajaran_id","pembimbing_kode","jam","tanggal","status"];

    protected $cascadeDeletes = ['anggota_zoom'];
    protected $dates = ['deleted_at'];

    /* anggota zoom */
    public function anggota_zoom()
    {
        return $this->belongsTo(PengajuanZoomAnggotaModel::class,'kode_anggota_zoom','anggota_zoom_kode');
    }

    /* inisiasi tahun */
    public function tahun()
    {
        return $this->belongsTo(TahunAjaran::class,'tahun_ajaran_id','id');
    }

    /* inisiasi pembimbing */
    public function pembimbing()
    {
        return $this->belongsTo(DosPemModel::class,'pembimbing_kode','kode_pembimbing');
    }
}
