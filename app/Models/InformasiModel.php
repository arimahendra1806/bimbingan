<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Models\NotifikasiModel;

class InformasiModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "informasi";
    protected $fillable = ["id", "users_id", "tahun_ajaran_id", "kepada_role", "kepada", "judul", "subyek", "pesan", "file_upload", "jenis"];

    protected $cascadeDeletes = ['notifikasi'];
    protected $dates = ['deleted_at'];

    /* notifikasi */
    public function notifikasi()
    {
        return $this->belongsTo(NotifikasiModel::class,'id','informasi_id');
    }

    /* inisiasi tahun */
    public function tahun()
    {
        return $this->belongsTo(TahunAjaran::class,'tahun_ajaran_id','id');
    }

    /* inisiasi users */
    public function pengirim()
    {
        return $this->belongsTo(User::class,'users_id','id');
    }

    /* inisiasi users */
    public function penerima()
    {
        return $this->belongsTo(User::class,'kepada','id');
    }
}
