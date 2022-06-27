<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\TahunAjaran;
use App\Models\FileMateriTahunanModel;

class MateriTahunanModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "ketentuan_ta";
    protected $fillable = ["id", "tahun_ajaran_id", "keterangan"];

    protected $cascadeDeletes = ['file'];
    protected $dates = ['deleted_at'];

    /* file */
    public function file()
    {
        return $this->belongsTo(FileMateriTahunanModel::class,'id','ketentuan_ta_id');
    }

    /* inisiasi tahun_ajaran */
    public function tahun()
    {
        return $this->belongsTo(TahunAjaran::class,'tahun_ajaran_id','id');
    }
}
