<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifikasiModel extends Model
{
    use HasFactory;
    protected $table = "notifikasi";
    protected $fillable = ["id", "identitas_id", "tahun_ajaran_id", "judul", "subyek", "status"];
}
