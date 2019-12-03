<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditoriaAcaoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditoria_acao', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_auditoria');
            $table->string('tabela', 200);
            $table->unsignedInteger('id_registro');
            $table->enum('acao_tabela', ['I', 'U', 'D'])->default('I');
            $table->text('dados_new');
            $table->text('dados_old');
            $table->text('dados_alt');
            $table->timestamps();

            $table->foreign('id_auditoria')->references('id')->on('auditoria');
            $table->index(array('id_registro', 'tabela'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('auditoria_acao');
    }

}
