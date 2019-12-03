<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricoTarefaTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_tarefa', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('situacao', ['ABERTO', 'CONCLUIDO', 'PENDENTE', 'CANCELADO', 'REPORTADA'])->default('ABERTO');
            $table->timestamp('data');
            $table->unsignedInteger('id_tarefa_processo');
            $table->timestamps();

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
        Schema::drop('historico_tarefa');
    }
}