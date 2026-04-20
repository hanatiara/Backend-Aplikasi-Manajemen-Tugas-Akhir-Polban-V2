<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kotas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kota');
            $table->string('prodi')->nullable();
            $table->string('tahun_ajaran')->nullable();
            $table->string('status')->nullable();
            $table->string('nama_mahasiswa1')->nullable();
            $table->string('nama_mahasiswa2')->nullable();
            $table->string('nama_mahasiswa3')->nullable();
            $table->string('nim1')->nullable();
            $table->string('nim2')->nullable();
            $table->string('nim3')->nullable();
            $table->string('judul_ta')->nullable();
            $table->bigInteger('id_user');
            $table->timestamps('');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kotas');
    }
}
