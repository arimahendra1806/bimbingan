<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DosenPembimbing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_pembimbing', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembimbing', 50);
            $table->integer('nidn');
            $table->integer('nim');
            $table->integer('tahun_ajaran_id');
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
        Schema::dropIfExists('dosen_pembimbing');
    }
}
