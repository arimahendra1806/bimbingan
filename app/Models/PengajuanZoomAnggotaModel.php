<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\PengajuanZoomModel;
use App\Models\DosPemModel;

class PengajuanZoomAnggotaModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "pengajuan_jadwal_zoom_anggota";
    protected $fillable = ["id","anggota_zoom_kode","pembimbing_kode"];

    protected $cascadeDeletes = [];
    protected $dates = ['deleted_at'];

    public function jadwal()
    {
        return $this->belongsTo(PengajuanZoomModel::class,'anggota_zoom_kode','kode_anggota_zoom');
    }

    public function pembimbing()
    {
        return $this->belongsTo(DosPemModel::class,'pembimbing_kode','kode_pembimbing');
    }
}
