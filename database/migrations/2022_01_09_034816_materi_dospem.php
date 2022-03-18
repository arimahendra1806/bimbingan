<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MateriDospem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materi_dospem', function (Blueprint $table) {
            $table->id();
            $table->integer('dosen_id');
            $table->integer('tahun_ajaran_id');
            $table->string('file_materi')->nullable();
            $table->string('jenis_materi')->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('materi_dospem');
    }
}
