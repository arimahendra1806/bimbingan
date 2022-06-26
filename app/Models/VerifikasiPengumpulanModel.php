<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\MahasiswaModel;
use App\Models\TahunAjaran;

class VerifikasiPengumpulanModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "verifikasi_pengumpulan";
    protected $fillable = ["id", "tahun_ajaran_id", "mahasiswa_id", "jenis", "nama_file", "status", "keterangan"];

    protected $cascadeDeletes = [];
    protected $dates = ['deleted_at'];

    /* inisiasi mahasiswa */
    public function mhs()
    {
        return $this->belongsTo(MahasiswaModel::class,'mahasiswa_id','id');
    }

    /* inisiasi tahun */
    public function tahun()
    {
        return $this->belongsTo(TahunAjaran::class,'tahun_ajaran_id','id');
    }
}
