<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\TahunAjaran;
use App\Models\MahasiswaModel;

class PengajuanJudulModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "pengajuan_judul";
    protected $fillable = ["id","mahasiswa_id","tahun_ajaran_id","judul","studi_kasus","pengerjaan","id_anggota","status"];

    protected $cascadeDeletes = [];
    protected $dates = ['deleted_at'];

    public function tahun()
    {
        return $this->belongsTo(TahunAjaran::class,'tahun_ajaran_id','id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class,'mahasiswa_id','id');
    }
}
