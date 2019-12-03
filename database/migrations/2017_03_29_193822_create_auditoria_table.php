<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditoriaTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditoria', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_perm_tipo_rota');
            $table->unsignedInteger('id_perm_rota');
            $table->text('dados_server');
            $table->text('dados_get');
            $table->text('dados_post');
            $table->string('endereco_ipv4', 20);
            $table->unsignedInteger('id_usuario');
            $table->timestamps();

            $table->foreign('id_perm_tipo_rota', 'auditoria_tipo_rota')->references('id')->on('perm_tipo_rota');
            $table->foreign('id_perm_rota', 'auditoria_rota')->references('id')->on('perm_rota');
            $table->foreign('id_usuario', 'auditoria_usuario')->references('id')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('auditoria');
    }

}
