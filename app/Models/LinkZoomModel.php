<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\TahunAjaran;
use App\Models\DosenModel;

class LinkZoomModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "link_zoom";
    protected $fillable = ["id","dosen_id","tahun_ajaran_id","id_meeting","passcode","link_zoom"];

    protected $cascadeDeletes = [];
    protected $dates = ['deleted_at'];

    /* inisiasi dosen */
    public function dosen()
    {
        return $this->belongsTo(DosenModel::class,'dosen_id','id');
    }

    /* inisiasi dosen */
    public function tahun()
    {
        return $this->belongsTo(TahunAjaran::class,'tahun_ajaran_id','id');
    }
}
