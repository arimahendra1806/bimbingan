<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\DosPemModel;
use App\Models\LinkZoomModel;
use App\Models\DosPemMateriModel;
use App\Models\User;

class DosenModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "dosen";
    protected $fillable = ["id", "users_id", "nidn", "nama_dosen", "alamat", "email", "no_telepon"];

    protected $cascadeDeletes = ['dospem','zoom','materi','user'];
    protected $dates = ['deleted_at'];

    /* dosen_pembimbing */
    public function dospem()
    {
        return $this->belongsTo(DosPemModel::class,'id','dosen_id');
    }

    /* link_zoom */
    public function zoom()
    {
        return $this->belongsTo(LinkZoomModel::class,'id','dosen_id');
    }

    /* materi_dospem */
    public function materi()
    {
        return $this->belongsTo(DosPemMateriModel::class,'id','dosen_id');
    }

    /* inisiasi users */
    public function user()
    {
        return $this->belongsTo(User::class,'users_id','id');
    }






}
