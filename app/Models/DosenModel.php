<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenModel extends Model
{
    use HasFactory;

    protected $table = "dosen";
    protected $fillable = ["id", "nidn", "nama_dosen", "alamat", "email", "no_telepon"];
}
