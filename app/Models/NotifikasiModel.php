<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\InformasiModel;

class NotifikasiModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "notifikasi";
    protected $fillable = ["id", "informasi_id", "kepada", "jenis", "status"];

    protected $cascadeDeletes = [];
    protected $dates = ['deleted_at'];

    /* inisiasi informasi */
    public function informasi()
    {
        return $this->belongsTo(InformasiModel::class,'informasi_id','id');
    }
}
