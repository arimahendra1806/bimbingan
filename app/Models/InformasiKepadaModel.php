<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\User;

class InformasiKepadaModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "informasi_kepada";
    protected $fillable = ["id", "informasi_id", "users_id"];

    protected $cascadeDeletes = [];
    protected $dates = ['deleted_at'];

    /* inisiasi users */
    public function nama()
    {
        return $this->belongsTo(User::class,'users_id','id');
    }
}
