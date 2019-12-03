<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComentarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 500);
            $table->unsignedInteger('id_processo');
            $table->unsignedInteger('id_tarefa_processo')->nullable();
            $table->timestamps();

            $table->foreign('id_processo')->references('id')->on('processo');
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
        Schema::drop('comentario');
    }
}
