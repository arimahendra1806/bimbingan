<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class DosPemMateriModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "materi_dospem";
    protected $fillable = ["id","dosen_id","tahun_ajaran_id","file_materi","jenis_materi","keterangan"];

    protected $cascadeDeletes = [];
    protected $dates = ['deleted_at'];
}
