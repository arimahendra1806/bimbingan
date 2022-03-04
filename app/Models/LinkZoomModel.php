<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TahunAjaran;

class LinkZoomModel extends Model
{
    use HasFactory;
    protected $table = "link_zoom";
    protected $fillable = ["id","nidn","tahun_ajaran_id","id_meeting","passcode","link_zoom"];

    public function tahun()
    {
        return $this->belongsTo(TahunAjaran::class,'tahun_ajaran_id','id');
    }
}
