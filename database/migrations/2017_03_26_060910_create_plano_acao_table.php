<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanoAcaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plano_acao', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('descricao')->nullable();
            $table->unsignedInteger('id_processo');
            $table->timestamps();

            $table->foreign('id_processo')->references('id')->on('processo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('plano_acao');
    }
}
