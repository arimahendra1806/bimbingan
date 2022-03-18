<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class PengajuanZoomModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "pengajuan_jadwal_zoom";
    protected $fillable = ["id","pembimbing_kode","tahun_ajaran_id","pembimbing_kode_1","pembimbing_kode_2","pembimbing_kode_3","pembimbing_kode_4","pembimbing_kode_5","jam","tanggal","status"];

    protected $cascadeDeletes = [];
    protected $dates = ['deleted_at'];
}
