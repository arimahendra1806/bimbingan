<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RiwayatBimbingan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat_bimbingan', function (Blueprint $table) {
            $table->id();
            $table->string('bimbingan_kode');
            $table->string('konsultasi_jenis');
            $table->string('konsultasi_bab');
            $table->datetime('waktu_konsultasi')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('riwayat_bimbingan');
    }
}
