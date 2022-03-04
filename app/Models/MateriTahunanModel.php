<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TahunAjaran;

class MateriTahunanModel extends Model
{
    use HasFactory;
    protected $table = "ketentuan_ta";
    protected $fillable = ["id", "tahun_ajaran_id", "file_materi", "keterangan"];

    public function tahun()
    {
        return $this->belongsTo(TahunAjaran::class,'tahun_ajaran_id','id');
    }
}
