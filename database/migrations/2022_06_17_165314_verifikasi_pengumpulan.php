<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VerifikasiPengumpulan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifikasi_pengumpulan', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun_ajaran_id');
            $table->integer('mahasiswa_id')->unique();
            $table->string('jenis', 50);
            $table->string('nama_file');
            $table->string('status', 150);
            $table->string('keterangan', 255);
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
        Schema::dropIfExists('verifikasi_pengumpulan');
    }
}
