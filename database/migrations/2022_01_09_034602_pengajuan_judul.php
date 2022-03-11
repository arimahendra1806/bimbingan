<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PengajuanJudul extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_judul', function (Blueprint $table) {
            $table->id();
            $table->integer('mahasiswa_id');
            $table->integer('tahun_ajaran_id');
            $table->string('judul')->nullable();
            $table->string('studi_kasus')->nullable();
            $table->string('pengerjaan')->nullable();
            $table->integer('id_anggota')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuan_judul');
    }
}
