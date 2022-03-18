<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class KomentarModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "komentar";
    protected $fillable = ["id","bimbingan_kode","bimbingan_jenis","nama","komentar","waktu_komentar"];

    protected $cascadeDeletes = [];
    protected $dates = ['deleted_at'];
}
