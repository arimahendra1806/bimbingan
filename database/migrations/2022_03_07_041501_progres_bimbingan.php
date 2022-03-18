<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProgresBimbingan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progres_bimbingan', function (Blueprint $table) {
            $table->id();
            $table->string('bimbingan_kode', 50);
            $table->integer('tahun_ajaran_id');
            $table->float('judul')->default('0');
            $table->float('proposal_bab1')->default('0');
            $table->float('proposal_bab2')->default('0');
            $table->float('proposal_bab3')->default('0');
            $table->float('proposal_bab4')->default('0');
            $table->float('laporan_bab1')->default('0');
            $table->float('laporan_bab2')->default('0');
            $table->float('laporan_bab3')->default('0');
            $table->float('laporan_bab4')->default('0');
            $table->float('laporan_bab5')->default('0');
            $table->float('laporan_bab6')->default('0');
            $table->float('program')->default('0');
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
        Schema::dropIfExists('progres_bimbingan');
    }
}
