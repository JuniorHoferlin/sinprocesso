<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarefaDependenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefa_dependencia', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_tarefa');
            $table->unsignedInteger('id_dependencia');
            $table->timestamps();

            $table->foreign('id_tarefa')->references('id')->on('tarefa');
            $table->foreign('id_dependencia')->references('id')->on('tarefa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tarefa_dependencia');
    }
}
