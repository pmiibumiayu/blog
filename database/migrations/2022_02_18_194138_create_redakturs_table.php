<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedaktursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redakturs', function (Blueprint $table) {
            $table->id();
            $table->string('redakturNama');
            $table->string('redakturEmail');
            $table->string('redakturNomor');
            $table->string('redakturAlamat');
            $table->string('redakturUniv');
            $table->string('redakturFakultas');
            $table->string('redakturProdi');
            $table->year('redakturKuliah');
            $table->year('redakturMapaba');
            $table->string('redakturFoto');
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
        Schema::dropIfExists('redakturs');
    }
}