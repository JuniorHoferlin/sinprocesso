<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessoRespostaFormularioTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processo_resposta_formulario', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_processo');
            $table->unsignedInteger('id_formulario');
            $table->unsignedInteger('id_formulario_campo');
            $table->string('resposta', 300);
            $table->timestamps();

            $table->foreign('id_processo', 'prf_p')->references('id')->on('processo');
            $table->foreign('id_formulario', 'prf_f')->references('id')->on('formulario');
            $table->foreign('id_formulario_campo', 'prf_fc')->references('id')->on('formulario_campo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('processo_resposta_formulario');
    }
}
