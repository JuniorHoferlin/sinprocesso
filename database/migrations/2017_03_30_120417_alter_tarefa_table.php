<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTarefaTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tarefa', function (Blueprint $table) {
            $table->dropForeign(['id_grupo_acesso']);
            $table->dropColumn('id_grupo_acesso');

            $table->unsignedInteger('id_grupo_acesso_area');
            $table->foreign('id_grupo_acesso_area', 'tarefa_garea')->references('id')->on('grupo_acesso_area');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarefa', function (Blueprint $table) {
            $table->dropForeign(['id_grupo_acesso_area']);
            $table->dropColumn('id_grupo_acesso_area');
        });
    }
}
