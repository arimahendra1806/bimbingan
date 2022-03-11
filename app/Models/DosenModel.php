<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;


class DosenModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "dosen";
    protected $fillable = ["id", "users_id", "nidn", "nama_dosen", "alamat", "email", "no_telepon"];
    protected $delete = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class,'users_id','id');
    }
}
