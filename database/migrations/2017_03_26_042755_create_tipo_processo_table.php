<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoProcessoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_processo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 500);
            $table->string('requesito', 500)->nullable();
            $table->unsignedInteger('id_formulario');
            $table->enum('tr', ['S', 'N'])->default('N');
            $table->timestamps();

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
        Schema::drop('tipo_processo');
    }
}
