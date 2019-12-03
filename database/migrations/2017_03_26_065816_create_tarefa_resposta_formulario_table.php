<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarefaRespostaFormularioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefa_resposta_formulario', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_tarefa_processo');
            $table->unsignedInteger('id_formulario');
            $table->unsignedInteger('id_formulario_campo');
            $table->string('resposta', 300);
            $table->timestamps();

            $table->foreign('id_tarefa_processo', 'trf_tp')->references('id')->on('tarefa_processo');
            $table->foreign('id_formulario', 'trf_f')->references('id')->on('formulario');
            $table->foreign('id_formulario_campo', 'trf_fc')->references('id')->on('formulario_campo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tarefa_resposta_formulario');
    }
}
