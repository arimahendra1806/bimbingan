<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosPemMateriModel extends Model
{
    use HasFactory;
    protected $table = "materi_dospem";
    protected $fillable = ["id","nidn","tahun_ajaran_id","file_materi","keterangan"];
}
