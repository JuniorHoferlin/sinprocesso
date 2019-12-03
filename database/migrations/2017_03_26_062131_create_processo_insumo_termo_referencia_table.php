<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessoInsumoTermoReferenciaTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processo_insumo_termo_ref', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_processo');
            $table->unsignedInteger('id_insumo_termo_referencia');
            $table->integer('quantidade');
            $table->timestamps();

            $table->foreign('id_processo', 'pitr_processo')->references('id')->on('processo');
            $table->foreign('id_insumo_termo_referencia', 'pitr_itr')->references('id')->on('insumo_termo_referencia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('processo_insumo_termo_ref');
    }
}
