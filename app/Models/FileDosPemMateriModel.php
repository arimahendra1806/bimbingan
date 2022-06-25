<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class FileDosPemMateriModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "file_materi_dospem";
    protected $fillable = ["id", "materi_dospem_id", "nama_file"];

    protected $cascadeDeletes = [];
    protected $dates = ['deleted_at'];
}
