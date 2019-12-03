<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsumoTermoReferenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo_termo_referencia', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_insumo');
            $table->unsignedInteger('id_termo_referencia');
            $table->integer('quantidade');
            $table->integer('media_consumo');
            $table->decimal('valor', 11, 2);
            $table->timestamps();

            $table->foreign('id_insumo')->references('id')->on('insumo');
            $table->foreign('id_termo_referencia')->references('id')->on('termo_referencia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('insumo_termo_referencia');
    }
}
