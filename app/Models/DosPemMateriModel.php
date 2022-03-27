<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\DosenModel;
use App\Models\TahunAjaran;

class DosPemMateriModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = "materi_dospem";
    protected $fillable = ["id","dosen_id","tahun_ajaran_id","file_materi","jenis_materi","keterangan"];

    protected $cascadeDeletes = [];
    protected $dates = ['deleted_at'];

    /**
     * Get the user that owns the DosPemMateriModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen()
    {
        return $this->belongsTo(DosenModel::class, 'dosen_id', 'id');
    }

    /**
     * Get the user that owns the DosPemMateriModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tahun()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'id');
    }
}
