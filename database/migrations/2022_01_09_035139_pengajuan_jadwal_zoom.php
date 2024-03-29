<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PengajuanJadwalZoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_jadwal_zoom', function (Blueprint $table) {
            $table->id();
            $table->string('kode_anggota_zoom', 50);
            $table->integer('tahun_ajaran_id');
            $table->string('pembimbing_kode', 50);
            $table->string('jam', 20);
            $table->date('tanggal');
            $table->string('status', 20);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuan_jadwal_zoom');
    }
}
