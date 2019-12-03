<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoProcessoTarefaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_processo_tarefa', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_tipo_processo');
            $table->unsignedInteger('id_tarefa');
            $table->integer('ordem')->default(0);
            $table->timestamps();

            $table->foreign('id_tipo_processo')->references('id')->on('tipo_processo');
            $table->foreign('id_tarefa')->references('id')->on('tarefa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tipo_processo_tarefa');
    }
}
