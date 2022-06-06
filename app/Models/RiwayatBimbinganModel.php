<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\BimbinganModel;

class RiwayatBimbinganModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "riwayat_bimbingan";
    protected $fillable = ["id","bimbingan_kode","peninjauan_kode","bimbingan_jenis","keterangan","tanggapan","status","waktu_bimbingan"];

    protected $cascadeDeletes = [];
    protected $dates = ['deleted_at'];

    /* bimbingan */
    public function bimbingan()
    {
        return $this->belongsTo(BimbinganModel::class,'peninjauan_kode','kode_peninjauan');
    }
}
