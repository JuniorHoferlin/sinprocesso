<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrupoAcessoAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupo_acesso_area', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_area');
            $table->unsignedInteger('id_grupo_acesso');
            $table->timestamps();

            $table->foreign('id_area')->references('id')->on('area');
            $table->foreign('id_grupo_acesso')->references('id')->on('grupo_acesso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('grupo_acesso_area');
    }
}
