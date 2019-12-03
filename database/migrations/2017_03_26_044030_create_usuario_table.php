<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 100);
            $table->string('cpf', 100)->unique();
            $table->string('matricula', 100)->nullable();
            $table->string('email', 300);
            $table->string('login', 100)->unique();
            $table->string('senha', 300);
            $table->unsignedInteger('id_cidade')->nullable();
            $table->unsignedInteger('id_funcao_area');
            $table->enum('status', ['Ativo', 'Inativo'])->default('Ativo');
            $table->timestamps();

            $table->foreign('id_cidade')->references('id')->on('cidade');
            $table->foreign('id_funcao_area')->references('id')->on('funcao_area');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('usuario');
    }
}
