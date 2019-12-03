<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarefaDocumentoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefa_processo_documento', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_tarefa_processo');
            $table->string('anexo', 500)->nullable();
            $table->string('titulo', 300);
            $table->unsignedInteger('id_usuario');
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
        Schema::drop('tarefa_processo_documento');
    }
}
