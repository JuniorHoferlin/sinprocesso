<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoProcessoGrupoAcessoAreaTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_processo_grupo_ac_area', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_tipo_processo');
            $table->unsignedInteger('id_grupo_acesso_area');
            $table->timestamps();

            $table->foreign('id_tipo_processo', 'tpgaa_tp')->references('id')->on('tipo_processo');
            $table->foreign('id_grupo_acesso_area', 'tpgaa_gaa')->references('id')->on('grupo_acesso_area');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tipo_processo_grupo_ac_area');
    }
}
