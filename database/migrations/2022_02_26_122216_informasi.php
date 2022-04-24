<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Informasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informasi', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id');
            $table->integer('tahun_ajaran_id');
            $table->string('kepada_role');
            $table->integer('kepada')->default('0');
            $table->string('judul')->nullable();
            $table->string('subyek')->nullable();
            $table->string('pesan')->nullable();
            $table->string('jenis')->nullable();
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
        Schema::dropIfExists('informasi');
    }
}
