<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsumoTermoReferenciaAddTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo_termo_referencia_add', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_insumo_termo_referencia');
            $table->unsignedInteger('id_usuario');
            $table->integer('quantidade');
            $table->longText('motivo');
            $table->timestamps();

            $table->foreign('id_insumo_termo_referencia', 'itra_itr')->references('id')->on('insumo_termo_referencia');
            $table->foreign('id_usuario', 'itra_u')->references('id')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('insumo_termo_referencia_add');
    }
}
