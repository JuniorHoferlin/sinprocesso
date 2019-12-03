<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarefaTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefa', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('identificador');
            $table->string('titulo', 200);
            $table->string('descricao', 350);
            $table->enum('tipo', ['PADRÃO', 'COMPRA', 'ASSINATURA'])->default('PADRÃO');
            $table->enum('exclusiva', ['S', 'N'])->default('N');
            $table->unsignedInteger('id_area');
            $table->unsignedInteger('id_grupo_acesso');
            $table->unsignedInteger('id_formulario')->nullable();
            $table->integer('prazo_minutos');
            $table->enum('tarefa_report', ['S', 'N'])->default('N');
            $table->timestamps();

            $table->foreign('id_area')->references('id')->on('area');
            $table->foreign('id_grupo_acesso')->references('id')->on('grupo_acesso');
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
        Schema::drop('tarefa');
    }
}
