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
            $table->string('peninjauan_kode', 50)->nullable();
            $table->string('bimbingan_jenis', 100);
            $table->string('keterangan', 255)->nullable();
            $table->string('tanggapan', 255)->nullable();
            $table->string('status', 100)->nullable();
            $table->datetime('waktu_bimbingan')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('riwayat_bimbingan');
    }
}
