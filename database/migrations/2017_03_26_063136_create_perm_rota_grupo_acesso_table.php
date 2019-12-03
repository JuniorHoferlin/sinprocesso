<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermRotaGrupoAcessoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perm_rota_grupo_acesso', function (Blueprint $table) {
            $table->unsignedInteger('id_perm_rota');
            $table->foreign('id_perm_rota')->references('id')->on('perm_rota');
            $table->unsignedInteger('id_grupo_acesso');
            $table->foreign('id_grupo_acesso')->references('id')->on('grupo_acesso');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perm_rota_grupo_acesso');
    }
}
