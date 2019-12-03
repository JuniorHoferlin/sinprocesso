<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarefaProcessoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefa_processo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_tarefa');
            $table->unsignedInteger('id_processo');
            $table->timestamp('data_abertura')->nullable();
            $table->timestamp('data_finalizado')->nullable();
            $table->longText('acao_executada')->nullable();
            $table->integer('ordem');
            $table->unsignedInteger('id_usuario_abertura')->nullable();
            $table->unsignedInteger('id_usuario_fechamento')->nullable();
            $table->unsignedInteger('id_tarefa_processo')->nullable();
            $table->enum('sala_situacao', ['S', 'N'])->default('N');
            $table->unsignedInteger('id_formulario')->nullable();
            $table->timestamps();

            $table->foreign('id_tarefa')->references('id')->on('tarefa');
            $table->foreign('id_processo')->references('id')->on('processo');
            $table->foreign('id_usuario_abertura')->references('id')->on('usuario');
            $table->foreign('id_usuario_fechamento')->references('id')->on('usuario');
            $table->foreign('id_tarefa_processo')->references('id')->on('tarefa_processo');
            $table->foreign('id_formulario')->references('id')->on('formulario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tarefa_processo');
    }
}
