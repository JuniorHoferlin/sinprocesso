<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrazoExecucaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prazo_execucao', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_tarefa_processo');
            $table->unsignedInteger('id_usuario');
            $table->timestamp('tempo_inicio')->nullable();
            $table->timestamp('tempo_fechamento')->nullable();
            $table->timestamps();

            $table->foreign('id_tarefa_processo')->references('id')->on('tarefa_processo');
            $table->foreign('id_usuario')->references('id')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prazo_execucao');
    }
}
