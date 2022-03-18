<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\User;
use App\Models\BimbinganModel;
use App\Models\DosPemModel;
use App\Models\InformasiModel;
use App\Models\MateriTahunanModel;
use App\Models\LinkZoomModel;
use App\Models\MahasiswaModel;
use App\Models\DosPemMateriModel;
use App\Models\NotifikasiModel;
use App\Models\PengajuanZoomModel;
use App\Models\PengajuanJudulModel;
use App\Models\ProgresBimbinganModel;

class TahunAjaran extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "tahun_ajaran";
    protected $fillable = ["id", "tahun_ajaran", "status"];

    protected $cascadeDeletes = ['userth','bimbinganth','dospemth','infoth','ketentuanth','linkth','mhsth','materith','notifth','zoomth','judulth','progresth'];
    protected $dates = ['deleted_at'];

    public function userth()
    {
        return $this->belongsTo(User::class,'id','tahun_ajaran_id');
    }

    public function bimbinganth()
    {
        return $this->belongsTo(BimbinganModel::class,'id','tahun_ajaran_id');
    }

    public function dospemth()
    {
        return $this->belongsTo(DosPemModel::class,'id','tahun_ajaran_id');
    }

    public function infoth()
    {
        return $this->belongsTo(InformasiModel::class,'id','tahun_ajaran_id');
    }

    public function ketentuanth()
    {
        return $this->belongsTo(MateriTahunanModel::class,'id','tahun_ajaran_id');
    }

    public function linkth()
    {
        return $this->belongsTo(LinkZoomModel::class,'id','tahun_ajaran_id');
    }

    public function mhsth()
    {
        return $this->belongsTo(MahasiswaModel::class,'id','tahun_ajaran_id');
    }

    public function materith()
    {
        return $this->belongsTo(DosPemMateriModel::class,'id','tahun_ajaran_id');
    }

    public function notifth()
    {
        return $this->belongsTo(NotifikasiModel::class,'id','tahun_ajaran_id');
    }

    public function zoomth()
    {
        return $this->belongsTo(PengajuanZoomModel::class,'id','tahun_ajaran_id');
    }

    public function judulth()
    {
        return $this->belongsTo(PengajuanJudulModel::class,'id','tahun_ajaran_id');
    }

    public function progresth()
    {
        return $this->belongsTo(ProgresBimbinganModel::class,'id','tahun_ajaran_id');
    }
}
