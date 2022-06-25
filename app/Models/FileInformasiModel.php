<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class FileInformasiModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "file_informasi";
    protected $fillable = ["id", "informasi_id", "nama_file"];

    protected $cascadeDeletes = [];
    protected $dates = ['deleted_at'];
}
