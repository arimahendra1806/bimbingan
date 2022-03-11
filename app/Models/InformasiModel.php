<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiModel extends Model
{
    use HasFactory;
    protected $table = "informasi";
    protected $fillable = ["id", "identitas_id", "tahun_ajaran_id", "kepada", "judul", "subyek", "pesan", "status"];
}
