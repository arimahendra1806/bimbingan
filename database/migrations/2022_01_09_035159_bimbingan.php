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
            $table->string('kode_komentar', 30);
            $table->string('pembimbing_kode', 50);
            $table->integer('tahun_ajaran_id');
            $table->string('file_upload')->nullable();
            $table->string('link_video')->nullable();
            $table->string('jenis_konsultasi')->nullable();
            $table->string('bab_konsultasi')->nullable();
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
        Schema::dropIfExists('bimbingan');
    }
}
