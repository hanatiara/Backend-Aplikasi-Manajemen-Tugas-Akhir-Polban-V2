<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBimbingan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bimbingans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_bimbingan');
            $table->string('topik_bimbingan');
            $table->string('catatan')->nullable();
            $table->string('id_kota');
            $table->string('status');
            $table->string('komentar');
            $table->string('id_pembimbing');
            $table->string('url')->nullable();
            $table->string('nama_file')->nullable();
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
        Schema::dropIfExists('bimbingans');
    }
}
