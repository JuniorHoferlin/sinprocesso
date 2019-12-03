<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessoDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processo_documento', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_processo');
            $table->unsignedInteger('id_documento');
            $table->timestamps();

            $table->foreign('id_processo')->references('id')->on('processo');
            $table->foreign('id_documento')->references('id')->on('documento_padrao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('processo_documento');
    }
}
