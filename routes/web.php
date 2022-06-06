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
use App\Http\Controllers\PengajuanZoomController;
use App\Http\Controllers\DosPemController;
use App\Http\Controllers\DataPembimbingController;
use App\Http\Controllers\JudulMahasiswaController;
use App\Http\Controllers\KonsulJudulController;
use App\Http\Controllers\KonsulProposalController;
use App\Http\Controllers\KonsulLaporanController;
use App\Http\Controllers\KonsulProgramController;
use App\Http\Controllers\PartialController;
use App\Http\Controllers\MateriDosenController;
use App\Http\Controllers\DsnKonsulJudulController;
use App\Http\Controllers\DsnKonsulProposalController;
use App\Http\Controllers\DsnKonsulLaporanController;
use App\Http\Controllers\DsnKonsulProgramController;
use App\Http\Controllers\ProgresKonsultasiController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PeringatanController;
use App\Http\Controllers\TopbarController;
use App\Http\Controllers\ProfilController;
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
    Route::get('/topbar/notif/informasi', [TopbarController::class, 'informasi'])->name('topbar-notif.informasi');
    Route::get('/topbar/notif/informasi/pengumuman', [TopbarController::class, 'informasiPengumuman'])->name('topbar-notif.pengumuman');
    Route::get('/topbar/notif/informasi/peringatan', [TopbarController::class, 'informasiPeringatan'])->name('topbar-notif.peringatan');
    Route::get('/topbar/notif/informasi/read/all', [TopbarController::class, 'readAll'])->name('topbar-notif.readAll');
    Route::get('/profil', [ProfilController::class, 'index'])->name('profile.index');
    Route::post('/profil', [ProfilController::class, 'update'])->name('profile.update');

    /* Koordinator */
    Route::group(['middleware' => 'CheckRole:koordinator'], function(){
        /* Kelola Tahun Ajaran */
        Route::resource('kelola-tahun-ajaran', TahunAjaranController::class, ['except' => [
            'destroy','update'
        ]]);
        Route::post('/kelola-tahun-ajaran/{tahun_ajaran}', [TahunAjaranController::class, 'update'])->name('kelola-tahun-ajaran.update');
        Route::post('/kelola-tahun-ajaran/delete/{tahun_ajaran}', [TahunAjaranController::class, 'destroy'])->name('kelola-tahun-ajaran.destroy');

        /* Kelola Materi Tahunan */
        Route::resource('kelola-materi-tahunan', MateriTahunanController::class, ['except' => [
            'destroy','update'
        ]]);
        Route::post('/kelola-materi-tahunan/{materi_tahunan}', [MateriTahunanController::class, 'update'])->name('kelola-materi-tahunan.update');
        Route::post('/kelola-materi-tahunan/delete/{materi_tahunan}', [MateriTahunanController::class, 'destroy'])->name('kelola-materi-tahunan.destroy');

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
        Route::resource('kelola-pengguna', UserController::class, ['except' => [
            'destroy','update'
        ]]);
        Route::post('/kelola-pengguna/{pengguna}', [UserController::class, 'update'])->name('kelola-pengguna.update');
        Route::post('/kelola-pengguna/delete/{pengguna}', [UserController::class, 'destroy'])->name('kelola-pengguna.destroy');

        /* Kelola Link Zoom */
        Route::resource('kelola-link-zoom', LinkZoomController::class, ['except' => [
            'destroy','update'
        ]]);
        Route::post('/kelola-link-zoom/{link_zoom}', [LinkZoomController::class, 'update'])->name('kelola-link-zoom.update');
        Route::post('/kelola-link-zoom/delete/{link_zoom}', [LinkZoomController::class, 'destroy'])->name('kelola-link-zoom.destroy');
        Route::post('/import/link', [LinkZoomController::class, 'import'])->name('kelola-link-zoom.import');

        /* Kelola Dosen Pembimbing */
        Route::resource('kelola-dosen-pembimbing', DosPemController::class, ['except' => [
            'destroy','update'
        ]]);
        Route::post('/kelola-dosen-pembimbing/{dosen_pembimbing}', [DosPemController::class, 'update'])->name('kelola-dosen-pembimbing.update');
        Route::post('/kelola-dosen-pembimbing/delete/{dosen_pembimbing}', [DosPemController::class, 'destroy'])->name('kelola-dosen-pembimbing.destroy');
        Route::get('/data/judul/pengajuan', [DosPemController::class, 'judul'])->name('kelola-dosen-pembimbing.judul');
        Route::get('/data/jumlah/pembimbing/{id}', [DosPemController::class, 'jumlahNidn'])->name('kelola-dosen-pembimbing.jumlahNidn');

        /* Data Judul Mahasiswa */
        Route::get('/judul-mahasiswa', [JudulMahasiswaController::class, 'indexKoor'])->name('judul-mahasiswa.indexKoor');
        Route::get('/export/judul/{params}', [JudulMahasiswaController::class, 'exportKoor'])->name('judul-mahasiswa.exportKoor');
    });

    /* Kaprodi */
    Route::group(['middleware' => 'CheckRole:kaprodi'], function(){
        /* Data Dosen */
        Route::get('/daftar-data-dosen', [DosenController::class, 'indexKaprodi'])->name('data-dosen.indexKaprodi');
        Route::get('/daftar-data-dosen/{data_dosen}', [DosenController::class, 'show'])->name('data-dosen.show');

        /* Data Mahasiswa */
        Route::get('/daftar-data-mahasiswa', [MahasiswaController::class, 'indexKaprodi'])->name('data-mhs.indexKaprodi');
        Route::get('/daftar-data-mahasiswa/{data_mahasiswa}', [MahasiswaController::class, 'show'])->name('data-mhs.show');

        /* Data Pembimbing */
        Route::get('/daftar-data-pembimbing', [JudulMahasiswaController::class, 'indexKaprodi'])->name('data-dospem.indexKaprodi');
        Route::get('/daftar-data-pembimbing/{data_pembimbing}', [JudulMahasiswaController::class, 'show'])->name('data-dospem.show');
    });

    /* Dosen */
    Route::group(['middleware' => 'CheckRole:dosen'], function(){

        /* Kelola Materi Dosen */
        Route::resource('materi-dosen', MateriDosenController::class, ['except' => [
            'update'
        ]]);
        Route::post('/materi-dosen/{materi_dosen}', [MateriDosenController::class, 'update'])->name('materi-dosen.update');
        Route::post('/materi-dosen/delete/{materi_dosen}', [MateriDosenController::class, 'destroy'])->name('materi-dosen.destroy');

        /* Data Pembimbing */
        Route::get('/data-mahasiswa', [DataPembimbingController::class, 'indexDsn'])->name('data-mahasiswa.indexDsn');
        Route::get('/data-mahasiswa/{id}', [DataPembimbingController::class, 'showDsn'])->name('data-mahasiswa.showDsn');

        /* Konsul Judul */
        Route::get('/peninjauan-konsultasi-judul', [DsnKonsulJudulController::class, 'index'])->name('peninjauan-judul.index');
        Route::get('/peninjauan-konsultasi-judul/{kode}', [DsnKonsulJudulController::class, 'detail'])->name('peninjauan-judul.detail');
        Route::get('/peninjauan-konsultasi-judul/komen/{kode}', [DsnKonsulJudulController::class, 'komen'])->name('peninjauan-judul.komen');
        Route::post('/peninjauan-konsultasi-judul', [DsnKonsulJudulController::class, 'store'])->name('peninjauan-judul.store');
        Route::post('/peninjauan-konsultasi-judul/komen', [DsnKonsulJudulController::class, 'storeKomen'])->name('peninjauan-judul.storeKomen');
        Route::get('/peninjauan-konsultasi-judul/riwayat/{kode}', [DsnKonsulJudulController::class, 'riwayat'])->name('peninjauan-judul.riwayat');
        Route::get('/peninjauan-konsultasi-judul/show/{id}', [DsnKonsulJudulController::class, 'show'])->name('peninjauan-judul.riwayat');

        /* Konsul Proposal */
        Route::get('/peninjauan-konsultasi-proposal', [DsnKonsulProposalController::class, 'index'])->name('peninjauan-proposal.index');
        Route::get('/peninjauan-konsultasi-proposal/{kode}', [DsnKonsulProposalController::class, 'detail'])->name('peninjauan-proposal.detail');
        Route::get('/peninjauan-konsultasi-proposal/komen/{kode}', [DsnKonsulProposalController::class, 'komen'])->name('peninjauan-proposal.komen');
        Route::post('/peninjauan-konsultasi-proposal', [DsnKonsulProposalController::class, 'store'])->name('peninjauan-proposal.store');
        Route::post('/peninjauan-konsultasi-proposal/komen', [DsnKonsulProposalController::class, 'storeKomen'])->name('peninjauan-proposal.storeKomen');
        Route::get('/peninjauan-konsultasi-proposal/riwayat/{kode}', [DsnKonsulProposalController::class, 'riwayat'])->name('peninjauan-proposal.riwayat');
        Route::get('/peninjauan-konsultasi-proposal/show/{id}', [DsnKonsulProposalController::class, 'show'])->name('peninjauan-proposal.riwayat');

        /* Konsul Laporan */
        Route::get('/peninjauan-konsultasi-laporan', [DsnKonsulLaporanController::class, 'index'])->name('peninjauan-laporan.index');
        Route::get('/peninjauan-konsultasi-laporan/{kode}', [DsnKonsulLaporanController::class, 'detail'])->name('peninjauan-laporan.detail');
        Route::get('/peninjauan-konsultasi-laporan/komen/{kode}', [DsnKonsulLaporanController::class, 'komen'])->name('peninjauan-laporan.komen');
        Route::post('/peninjauan-konsultasi-laporan', [DsnKonsulLaporanController::class, 'store'])->name('peninjauan-laporan.store');
        Route::post('/peninjauan-konsultasi-laporan/komen', [DsnKonsulLaporanController::class, 'storeKomen'])->name('peninjauan-laporan.storeKomen');
        Route::get('/peninjauan-konsultasi-laporan/riwayat/{kode}', [DsnKonsulLaporanController::class, 'riwayat'])->name('peninjauan-laporan.riwayat');
        Route::get('/peninjauan-konsultasi-laporan/show/{id}', [DsnKonsulLaporanController::class, 'show'])->name('peninjauan-laporan.riwayat');

        /* Konsul Program */
        Route::get('/peninjauan-konsultasi-program', [DsnKonsulProgramController::class, 'index'])->name('peninjauan-program.index');
        Route::get('/peninjauan-konsultasi-program/{kode}', [DsnKonsulProgramController::class, 'detail'])->name('peninjauan-program.detail');
        Route::get('/peninjauan-konsultasi-program/komen/{kode}', [DsnKonsulProgramController::class, 'komen'])->name('peninjauan-program.komen');
        Route::post('/peninjauan-konsultasi-program', [DsnKonsulProgramController::class, 'store'])->name('peninjauan-program.store');
        Route::post('/peninjauan-konsultasi-program/komen', [DsnKonsulProgramController::class, 'storeKomen'])->name('peninjauan-program.storeKomen');
        Route::get('/peninjauan-konsultasi-program/riwayat/{kode}', [DsnKonsulProgramController::class, 'riwayat'])->name('peninjauan-program.riwayat');
        Route::get('/peninjauan-konsultasi-program/show/{id}', [DsnKonsulProgramController::class, 'show'])->name('peninjauan-program.riwayat');

        /* Peninjauan Jadwal Zoom */
        Route::get('/peninjauan-jadwal-zoom', [PengajuanZoomController::class, 'indexDsn'])->name('peninjauan-jadwal-zoom.indexDsn');
        Route::get('/peninjauan-jadwal-zoom/{peninjauan_zoom}', [PengajuanZoomController::class, 'showDsn'])->name('peninjauan-jadwal-zoom.showDsn');
        Route::post('/peninjauan-jadwal-zoom/{peninjauan_zoom}', [PengajuanZoomController::class, 'updateDsn'])->name('peninjauan-jadwal-zoom.updateDsn');

    });

    /* Mahasiswa */
    Route::group(['middleware' => 'CheckRole:mahasiswa'], function(){

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
        Route::get('/konsultasi-judul/riwayat', [KonsulJudulController::class, 'riwayat'])->name('bimbingan-judul.riwayat');
        Route::post('/konsultasi-judul/{konsultasi_judul}', [KonsulJudulController::class, 'update'])->name('bimbingan-judul.update');
        Route::get('/konsultasi-judul/show/{konsultasi_judul}', [KonsulJudulController::class, 'show'])->name('bimbingan-judul.show');

        /* Konsul Proposal */
        Route::get('/konsultasi-proposal', [KonsulProposalController::class, 'index'])->name('bimbingan-proposal.index');
        Route::post('/konsultasi-proposal/store', [KonsulProposalController::class, 'store'])->name('bimbingan-proposal.store');
        Route::post('/komen/proposal/store', [KonsulProposalController::class, 'storeKomen'])->name('bimbingan-proposal.storeKomen');
        Route::get('/kartu-bimbingan-proposal', [KonsulProposalController::class, 'cetakPdf'])->name('kartu-proposal.cetak');
        Route::get('/konsultasi-proposal/riwayat', [KonsulProposalController::class, 'riwayat'])->name('bimbingan-proposal.riwayat');
        Route::post('/konsultasi-proposal/{konsultasi_proposal}', [KonsulProposalController::class, 'update'])->name('bimbingan-proposal.update');
        Route::get('/konsultasi-proposal/show/{konsultasi_proposal}', [KonsulProposalController::class, 'show'])->name('bimbingan-proposal.show');

        /* Konsul Laporan */
        Route::get('/konsultasi-laporan', [KonsulLaporanController::class, 'index'])->name('bimbingan-laporan.index');
        Route::post('/konsultasi-laporan/store', [KonsulLaporanController::class, 'store'])->name('bimbingan-laporan.store');
        Route::post('/komen/laporan/store', [KonsulLaporanController::class, 'storeKomen'])->name('bimbingan-laporan.storeKomen');
        Route::get('/kartu-bimbingan-laporan', [KonsulLaporanController::class, 'cetakPdf'])->name('kartu-laporan.cetak');
        Route::get('/konsultasi-laporan/riwayat', [KonsulLaporanController::class, 'riwayat'])->name('bimbingan-laporan.riwayat');
        Route::post('/konsultasi-laporan/{konsultasi_laporan}', [KonsulLaporanController::class, 'update'])->name('bimbingan-laporan.update');
        Route::get('/konsultasi-laporan/show/{konsultasi_laporan}', [KonsulLaporanController::class, 'show'])->name('bimbingan-laporan.show');

        /* Konsul Program */
        Route::get('/konsultasi-program', [KonsulProgramController::class, 'index'])->name('bimbingan-program.index');
        Route::post('/konsultasi-program/store', [KonsulProgramController::class, 'store'])->name('bimbingan-program.store');
        Route::post('/komen/program/store', [KonsulProgramController::class, 'storeKomen'])->name('bimbingan-program.storeKomen');
        Route::get('/konsultasi-program/riwayat', [KonsulProgramController::class, 'riwayat'])->name('bimbingan-program.riwayat');
        Route::post('/konsultasi-program/{konsultasi_program}', [KonsulProgramController::class, 'update'])->name('bimbingan-program.update');
        Route::get('/konsultasi-program/show/{konsultasi_program}', [KonsulProgramController::class, 'show'])->name('bimbingan-program.show');

        /* Pengumuman */
        Route::get('/pengumuman', [PengumumanController::class, 'indexMhs'])->name('pengumuman.indexMhs');
        Route::get('/pengumuman/role/info', [PengumumanController::class, 'roleInfo'])->name('pengumuman.roleInfo');
        Route::get('/pengumuman/role/info/{pengumuman}', [PengumumanController::class, 'roleDetail'])->name('pengumuman.roleDetail');

        /* Peringatan */
        Route::get('/peringatan', [PeringatanController::class, 'indexMhs'])->name('peringatan.indexMhs');
        Route::get('/peringatan/role/info', [PeringatanController::class, 'roleInfo'])->name('peringatan.roleInfo');
        Route::get('/peringatan/role/info/{peringatan}', [PeringatanController::class, 'roleDetail'])->name('peringatan.roleDetail');

        /* Kelola Pengajuan Zoom */
        Route::resource('pengajuan-zoom', PengajuanZoomController::class, ['except' => [
            'update'
        ]]);
        Route::post('/pengajuan-zoom/{pengajuan_zoom}', [PengajuanZoomController::class, 'update'])->name('pengajuan-zoom.update');

        /* Mhs Partial */
        Route::get('/materi/{jenis}', [PartialController::class, 'MateriKonsul'])->name('partial.MateriKonsul');
        // Route::get('/riwayat/{jenis}', [PartialController::class, 'RiwayatKonsul'])->name('partial.RiwayatKonsul');
        Route::get('/jadwal-zoom', [PartialController::class, 'JadwalZoom'])->name('partial.JadwalZoom');
        Route::post('/jadwal-zoom/{kode}', [PartialController::class, 'JadwalZoomStore'])->name('partial.JadwalZoomStore');
        Route::get('/riwayat-jadwal-zoom', [PartialController::class, 'RiwayatJadwalZoom'])->name('partial.RiwayatJadwalZoom');
        Route::get('/riwayat-jadwal-zoom/{riwayat}', [PartialController::class, 'RiwayatJadwalZoomShow'])->name('partial.RiwayatJadwalZoomShow');
    });

    /* Mahasiswa && Dosen */
    Route::group(['middleware' => 'CheckRole:mahasiswa,dosen'], function(){
        /* Ketentuan TA */
        Route::get('/ketentuan-ta', [KetentuanTaController::class, 'index'])->name('ketentuan-ta.index');
    });

    /* Koordinator && Dosen && Kaprodi */
    Route::group(['middleware' => 'CheckRole:koordinator,dosen,kaprodi'], function(){
        /* Progres */
        Route::get('/progres-konsultasi-mahasiswa', [ProgresKonsultasiController::class, 'index'])->name('progres-konsultasi.index');
        Route::get('/progres-konsultasi-mahasiswa/{id}/{urutan}', [ProgresKonsultasiController::class, 'show'])->name('progres-konsultasi.show');

        /* Pengumuman */
        Route::resource('kelola-pengumuman', PengumumanController::class, ['except' => [
            'update'
        ]]);
        Route::post('/kelola-pengumuman/{pengumuman}', [PengumumanController::class, 'update'])->name('kelola-pengumuman.update');
        Route::post('/kelola-pengumuman/delete/{pengumuman}', [PengumumanController::class, 'destroy'])->name('kelola-pengumuman.destroy');
        Route::get('/kelola-pengumuman/kepada/{pengumuman}', [PengumumanController::class, 'kepada'])->name('kelola-pengumuman.kepada');
        Route::get('/kelola-pengumuman/role/info', [PengumumanController::class, 'roleInfo'])->name('kelola-pengumuman.roleInfo');
        Route::get('/kelola-pengumuman/role/info/{pengumuman}', [PengumumanController::class, 'roleDetail'])->name('kelola-pengumuman.roleDetail');

        /* Peringatan */
        Route::resource('kelola-peringatan', PeringatanController::class, ['except' => [
            'update'
        ]]);
        Route::post('/kelola-peringatan/{peringatan}', [PeringatanController::class, 'update'])->name('kelola-peringatan.update');
        Route::post('/kelola-peringatan/delete/{peringatan}', [PeringatanController::class, 'destroy'])->name('kelola-peringatan.destroy');
        Route::get('/kelola-peringatan/kepada/{peringatan}', [PeringatanController::class, 'kepada'])->name('kelola-peringatan.kepada');
        Route::get('/kelola-peringatan/role/info', [PeringatanController::class, 'roleInfo'])->name('kelola-peringatan.roleInfo');
        Route::get('/kelola-peringatan/role/info/{peringatan}', [PeringatanController::class, 'roleDetail'])->name('kelola-peringatan.roleDetail');
    });
});
