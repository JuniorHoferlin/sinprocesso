<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarefaInsumoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefa_insumo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_processo_insumo');
            $table->unsignedInteger('id_tarefa_processo');
            $table->integer('quantidade');
            $table->timestamps();

            $table->foreign('id_processo_insumo')->references('id')->on('processo_insumo_termo_ref');
            $table->foreign('id_tarefa_processo')->references('id')->on('tarefa_processo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tarefa_insumo');
    }
}
