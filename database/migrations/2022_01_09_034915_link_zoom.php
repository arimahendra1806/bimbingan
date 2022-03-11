<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LinkZoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_zoom', function (Blueprint $table) {
            $table->id();
            $table->integer('dosen_id');
            $table->integer('tahun_ajaran_id');
            $table->string('id_meeting')->nullable();
            $table->string('passcode')->nullable();
            $table->string('link_zoom')->nullable();
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
        Schema::dropIfExists('link_zoom');
    }
}
