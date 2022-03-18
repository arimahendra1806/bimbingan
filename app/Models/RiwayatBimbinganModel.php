<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class RiwayatBimbinganModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "riwayat_bimbingan";
    protected $fillable = ["id","bimbingan_kode","bimbingan_jenis","waktu_bimbingan"];

    protected $cascadeDeletes = [];
    protected $dates = ['deleted_at'];
}
