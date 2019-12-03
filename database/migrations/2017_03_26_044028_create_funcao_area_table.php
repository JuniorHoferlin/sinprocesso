<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFuncaoAreaTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcao_area', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_area');
            $table->unsignedInteger('id_funcao');
            $table->timestamps();

            $table->foreign('id_area')->references('id')->on('area');
            $table->foreign('id_funcao')->references('id')->on('funcao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('funcao');
    }
}
