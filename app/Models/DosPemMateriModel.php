<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\DosenModel;
use App\Models\TahunAjaran;
use App\Models\FileDosPemMateriModel;

class DosPemMateriModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "materi_dospem";
    protected $fillable = ["id","dosen_id","tahun_ajaran_id","file_materi","jenis_materi","keterangan"];

    protected $cascadeDeletes = [];
    protected $dates = ['deleted_at'];

    /* file */
    public function file()
    {
        return $this->belongsTo(FileDosPemMateriModel::class,'id','materi_dospem_id');
    }

    /* inisiasi dosen */
     public function dosen()
    {
        return $this->belongsTo(DosenModel::class, 'dosen_id', 'id');
    }

    /* inisiasi tahun_ajaran */
    public function tahun()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'id');
    }
}
