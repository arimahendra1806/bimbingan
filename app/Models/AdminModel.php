<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\User;

class AdminModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "admin";
    protected $fillable = ["id", "users_id", "nip", "nama_admin", "alamat", "email", "no_telepon"];

    protected $cascadeDeletes = ['user'];
    protected $dates = ['deleted_at'];

    /* inisiasi users */
    public function user()
    {
        return $this->belongsTo(User::class,'users_id','id');
    }
}
