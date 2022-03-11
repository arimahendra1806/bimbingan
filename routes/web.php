<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Auth;
/* Controller */
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MateriTahunanController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\LinkZoomController;
use App\Http\Controllers\KetentuanTaController;
use App\Http\Controllers\PengajuanJudulController;
use App\Http\Controllers\DosPemController;
use App\Http\Controllers\DataPembimbingController;
use App\Http\Controllers\JudulMahasiswaController;
use App\Http\Controllers\KonsulJudulController;
use App\Http\Controllers\KonsulProposalController;
use App\Http\Controllers\PartialController;
/* End Controller */

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [DosPemController::class, 'test']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/* Login */
Route::get('/login', [AuthController::class, 'login']);

/* Post Login */
Route::post('/postlogin', [AuthController::class, 'postlogin'])->name('postlogin');

/* Logout */
Route::get('/logout', [AuthController::class, 'logout']);

/* Middleware && Auth */
Route::group(['middleware' => 'auth'], function(){
    Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard.home');

    /* Koordinator */
    Route::group(['middleware' => 'CheckRole:koordinator'], function(){
        /* Kelola Tahun Ajaran */
        Route::resource('tahun-ajaran', TahunAjaranController::class, ['except' => [
            'destroy','update'
        ]]);
        Route::post('/tahun-ajaran/{tahun_ajaran}', [TahunAjaranController::class, 'update'])->name('tahun-ajaran.update');
        Route::post('/tahun-ajaran/delete/{tahun_ajaran}', [TahunAjaranController::class, 'destroy'])->name('tahun-ajaran.destroy');

        /* Kelola Materi Tahunan */
        Route::resource('materi-tahunan', MateriTahunanController::class, ['except' => [
            'destroy','update'
        ]]);
        Route::post('/materi-tahunan/{materi_tahunan}', [MateriTahunanController::class, 'update'])->name('materi-tahunan.update');
        Route::post('/materi-tahunan/delete/{materi_tahunan}', [MateriTahunanController::class, 'destroy'])->name('materi-tahunan.destroy');

        /* Kelola Dosen */
        Route::resource('kelola-dosen', DosenController::class, ['except' => [
            'destroy','update'
        ]]);
        Route::post('/kelola-dosen/{kelola_dosen}', [DosenController::class, 'update'])->name('kelola-dosen.update');
        Route::post('/kelola-dosen/delete/{kelola_dosen}', [DosenController::class, 'destroy'])->name('kelola-dosen.destroy');
        Route::post('/import/dosen', [DosenController::class, 'import'])->name('kelola-dosen.import');

        /* Kelola Mahasiswa */
        Route::resource('kelola-mahasiswa', MahasiswaController::class, ['except' => [
            'destroy','update'
        ]]);
        Route::post('/kelola-mahasiswa/{kelola_mahasiswa}', [MahasiswaController::class, 'update'])->name('kelola-mahasiswa.update');
        Route::post('/kelola-mahasiswa/delete/{kelola_mahasiswa}', [MahasiswaController::class, 'destroy'])->name('kelola-mahasiswa.destroy');
        Route::post('/import/mahasiswa', [MahasiswaController::class, 'import'])->name('kelola-mahasiswa.import');

        /* Kelola Pengguna */
        Route::resource('pengguna', UserController::class, ['except' => [
            'destroy','update'
        ]]);
        Route::post('/pengguna/{pengguna}', [UserController::class, 'update'])->name('pengguna.update');
        Route::post('/pengguna/delete/{pengguna}', [UserController::class, 'destroy'])->name('pengguna.destroy');

        /* Kelola Link Zoom */
        Route::resource('link-zoom', LinkZoomController::class, ['except' => [
            'destroy','update'
        ]]);
        Route::post('/link-zoom/{link_zoom}', [LinkZoomController::class, 'update'])->name('link-zoom.update');
        Route::post('/link-zoom/delete/{link_zoom}', [LinkZoomController::class, 'destroy'])->name('link-zoom.destroy');
        Route::post('/import/link', [LinkZoomController::class, 'import'])->name('link-zoom.import');

        /* Kelola Dosen Pembimbing */
        Route::resource('dosen-pembimbing', DosPemController::class, ['except' => [
            'destroy','update'
        ]]);
        Route::post('/dosen-pembimbing/{dosen_pembimbing}', [DosPemController::class, 'update'])->name('dosen-pembimbing.update');
        Route::post('/dosen-pembimbing/delete/{dosen_pembimbing}', [DosPemController::class, 'destroy'])->name('dosen-pembimbing.destroy');
        Route::get('/data/judul/pengajuan', [DosPemController::class, 'judul'])->name('dosen-pembimbing.judul');
        Route::get('/data/jumlah/pembimbing/{nidn}', [DosPemController::class, 'jumlahNidn'])->name('dosen-pembimbing.jumlahNidn');

        /* Data Judul Mahasiswa */
        Route::get('/judul-mahasiswa', [JudulMahasiswaController::class, 'indexKoor'])->name('judul-mahasiswa.indexKoor');
        Route::post('/export/judul', [JudulMahasiswaController::class, 'exportKoor'])->name('judul-mahasiswa.exportKoor');
    });

    /* Kaprodi */
    Route::group(['middleware' => 'CheckRole:kaprodi'], function(){
    });

    /* Dosen */
    Route::group(['middleware' => 'CheckRole:dosen'], function(){
    });

    /* Mahasiswa */
    Route::group(['middleware' => 'CheckRole:mahasiswa'], function(){

        /* Ketentuan TA */
        Route::get('/ketentuan-ta', [KetentuanTaController::class, 'indexMhs'])->name('ketentuan-ta.indexMhs');
        Route::get('/download/ketentuan/mhs/{ketentuan_ta}', [KetentuanTaController::class, 'downloadMhs'])->name('download.indexMhs');

        /* Kelola Pengajuan Judul */
        Route::resource('pengajuan-judul', PengajuanJudulController::class, ['except' => [
            'update'
        ]]);
        Route::post('/pengajuan-judul/{pengajuan_judul}', [PengajuanJudulController::class, 'update'])->name('pengajuan-judul.update');

        /* Data Pembimbing */
        Route::get('/data-pembimbing', [DataPembimbingController::class, 'indexMhs'])->name('data-pembimbing.indexMhs');

        /* Konsul Judul */
        Route::get('/konsultasi-judul', [KonsulJudulController::class, 'index'])->name('bimbingan-judul.index');
        Route::post('/konsultasi-judul/store', [KonsulJudulController::class, 'store'])->name('bimbingan-judul.store');
        Route::post('/komen/judul/store', [KonsulJudulController::class, 'storeKomen'])->name('bimbingan-judul.storeKomen');

        /* Konsul Proposal */
        Route::get('/konsultasi-proposal', [KonsulProposalController::class, 'index'])->name('bimbingan-proposal.index');
        Route::post('/konsultasi-proposal/store', [KonsulProposalController::class, 'store'])->name('bimbingan-proposal.store');
        Route::post('/komen/proposal/store', [KonsulProposalController::class, 'storeKomen'])->name('bimbingan-proposal.storeKomen');

        /* Mhs Partial */
        Route::get('/materi/{proposal}', [PartialController::class, 'MateriKonsul'])->name('partial.MateriKonsul');
        Route::get('/riwayat/{proposal}', [PartialController::class, 'RiwayatKonsul'])->name('partial.RiwayatKonsul');
    });
});
