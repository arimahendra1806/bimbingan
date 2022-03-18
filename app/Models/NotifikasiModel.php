<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class NotifikasiModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "notifikasi";
    protected $fillable = ["id", "users_id", "tahun_ajaran_id", "judul", "subyek", "status"];

    protected $cascadeDeletes = [];
    protected $dates = ['deleted_at'];
}
