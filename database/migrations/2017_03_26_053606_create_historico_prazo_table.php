<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoPrazoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_prazo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prazo_minuto');
            $table->unsignedInteger('id_tarefa');
            $table->timestamps();

            $table->foreign('id_tarefa')->references('id')->on('tarefa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('historico_prazo');
    }
}
