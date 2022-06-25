<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Admin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id')->default('0')->unique();
            $table->string('nip', 20)->unique();
            $table->string('nama_admin', 150)->nullable();
            $table->string('alamat')->nullable();
            $table->string('email', 100)->nullable()->unique();
            $table->string('no_telepon', 20)->nullable();
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
        Schema::dropIfExists('admin');
    }
}
