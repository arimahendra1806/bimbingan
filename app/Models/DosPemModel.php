<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\PengajuanZoomModel;
use App\Models\BimbinganModel;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use App\Models\PengajuanJudulModel;
use App\Models\TahunAjaran;

class DosPemModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "dosen_pembimbing";
    protected $fillable = ["id","kode_pembimbing","dosen_id","mahasiswa_id","tahun_ajaran_id"];

    protected $cascadeDeletes = ['pengajuan','pengajuan1','pengajuan2','pengajuan3','pengajuan4','pengajuan5','bimbingan'];
    protected $dates = ['deleted_at'];

    /* pengajuan_jadwal_zoom */
    public function pengajuan()
    {
        return $this->belongsTo(PengajuanZoomModel::class,'kode_pembimbing','pembimbing_kode');
    }

    /* pengajuan_jadwal_zoom */
    public function pengajuan1()
    {
        return $this->belongsTo(PengajuanZoomModel::class,'kode_pembimbing','pembimbing_kode_1');
    }

    /* pengajuan_jadwal_zoom */
    public function pengajuan2()
    {
        return $this->belongsTo(PengajuanZoomModel::class,'kode_pembimbing','pembimbing_kode_2');
    }

    /* pengajuan_jadwal_zoom */
    public function pengajuan3()
    {
        return $this->belongsTo(PengajuanZoomModel::class,'kode_pembimbing','pembimbing_kode_3');
    }

    /* pengajuan_jadwal_zoom */
    public function pengajuan4()
    {
        return $this->belongsTo(PengajuanZoomModel::class,'kode_pembimbing','pembimbing_kode_4');
    }

    /* pengajuan_jadwal_zoom */
    public function pengajuan5()
    {
        return $this->belongsTo(PengajuanZoomModel::class,'kode_pembimbing','pembimbing_kode_5');
    }

    /* bimbingan */
    public function bimbingan()
    {
        return $this->belongsTo(BimbinganModel::class,'kode_pembimbing','pembimbing_kode');
    }

    /* inisiasi dosen */
    public function dosen()
    {
        return $this->belongsTo(DosenModel::class,'dosen_id','id');
    }

    /* inisiasi mahasiswa */
    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class,'mahasiswa_id','id');
    }

    /* inisiasi judul */
    public function judul()
    {
        return $this->belongsTo(PengajuanJudulModel::class,'mahasiswa_id','mahasiswa_id');
    }

    /* inisiasi tahun */
    public function tahun()
    {
        return $this->belongsTo(TahunAjaran::class,'tahun_ajaran_id','id');
    }

}
