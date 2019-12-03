<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSituacaoRegraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('situacao_regra', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_processo');
            $table->unsignedInteger('id_regra_processo');
            $table->enum('situacao', ['0', '1'])->default(0);
            $table->longText('descricao')->nullable();
            $table->timestamps();

            $table->foreign('id_processo')->references('id')->on('processo');
            $table->foreign('id_regra_processo')->references('id')->on('regra_processo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('situacao_regra');
    }
}
