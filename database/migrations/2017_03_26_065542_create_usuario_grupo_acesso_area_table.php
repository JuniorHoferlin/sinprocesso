<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioGrupoAcessoAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_grupo_acesso_area', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_grupo_acesso_area');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id')->on('usuario');
            $table->foreign('id_grupo_acesso_area')->references('id')->on('grupo_acesso_area');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('usuario_grupo_acesso_area');
    }
}
