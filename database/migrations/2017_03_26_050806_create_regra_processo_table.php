<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegraProcessoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regra_processo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_tipo_regra');
            $table->unsignedInteger('id_tipo_processo');
            $table->string('descricao', 500);
            $table->string('titulo', 100);
            $table->timestamps();

            $table->foreign('id_tipo_regra')->references('id')->on('tipo_regra');
            $table->foreign('id_tipo_processo')->references('id')->on('tipo_processo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('regra_processo');
    }
}
