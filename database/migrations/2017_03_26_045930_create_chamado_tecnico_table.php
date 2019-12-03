<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChamadoTecnicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chamado_tecnico', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 500);
            $table->unsignedInteger('id_usuario');
            $table->longText('problema_relatado')->nullable();
            $table->timestamp('data_abertura');
            $table->timestamp('data_fechamento')->nullable();
            $table->unsignedInteger('id_usuario_atendente')->nullable();
            $table->longText('solucao')->nullable();
            $table->timestamps();

            $table->foreign('id_usuario')->references('id')->on('usuario');
            $table->foreign('id_usuario_atendente')->references('id')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chamado_tecnico');
    }
}
