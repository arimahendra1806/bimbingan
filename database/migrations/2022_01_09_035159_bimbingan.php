<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Bimbingan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bimbingan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bimbingan', 50);
            $table->string('pembimbing_kode', 50);
            $table->integer('tahun_ajaran_id');
            $table->string('file_upload')->nullable();
            $table->string('link_video')->nullable();
            $table->string('jenis_bimbingan')->nullable();
            $table->string('status_konsultasi', 150)->nullable();
            $table->string('status_pesan', 150)->nullable();
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
        Schema::dropIfExists('bimbingan');
    }
}
