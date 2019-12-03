<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_termo_referencia')->nullable();
            $table->unsignedInteger('id_area')->nullable();
            $table->string('detalhamento', 500)->nullable();
            $table->string('numero_cipar', 100)->nullable();
            $table->timestamp('data_inicio');
            $table->timestamp('data_fim')->nullable();
            $table->enum('status', ['ABERTO', 'FINALIZADO', 'BLOQUEADO'])->default('ABERTO');
            $table->string('dados_objetivo', 300)->nullable();
            $table->unsignedInteger('id_formulario');
            $table->unsignedInteger('id_tipo_processo');
            $table->string('descricao', 500)->nullable();
            $table->unsignedInteger('id_modalidade')->nullable();
            $table->timestamps();

            $table->foreign('id_termo_referencia')->references('id')->on('termo_referencia');
            $table->foreign('id_area')->references('id')->on('area');
            $table->foreign('id_formulario')->references('id')->on('formulario');
            $table->foreign('id_tipo_processo')->references('id')->on('tipo_processo');
            $table->foreign('id_modalidade')->references('id')->on('modalidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('processo');
    }
}
