<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TahunAjaran extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "tahun_ajaran";
    protected $fillable = ["id", "tahun_ajaran", "status"];
    protected $delete = ['deleted_at'];
}
