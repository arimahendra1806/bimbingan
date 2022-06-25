<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\DosenModel;
use App\Models\InfomasiModel;
use App\Models\MahasiswaModel;
use App\Models\NotifikasiModel;
use App\Models\AdminModel;
use App\Models\TahunAjaran;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, CascadeSoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'username',
        'tahun_ajaran_id',
        'name',
        'role',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $cascadeDeletes = ['informasi','informasiKepada','notifikasi'];
    protected $dates = ['deleted_at'];

    /* informasi */
    public function informasi()
    {
        return $this->belongsTo(InformasiModel::class,'id','users_id');
    }

    /* informasi */
    public function informasiKepada()
    {
        return $this->belongsTo(InformasiModel::class,'id','kepada');
    }

    /* notifikasi */
    public function notifikasi()
    {
        return $this->belongsTo(NotifikasiModel::class,'id','kepada');
    }

    /* dosen */
    public function dosen()
    {
        return $this->belongsTo(DosenModel::class,'id','users_id');
    }

    /* mahasiswa */
    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class,'id','users_id');
    }

    /* admin */
    public function admin()
    {
        return $this->belongsTo(AdminModel::class,'id','users_id');
    }

    /* inisiasi tahun */
    public function tahun()
    {
        return $this->belongsTo(TahunAjaran::class,'tahun_ajaran_id','id');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


}
