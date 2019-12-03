<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermRotaTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perm_rota', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao');
            $table->string('rota');
            $table->enum('acesso_liberado', ['S', 'N'])->default('N');
            $table->enum('desenv', ['S', 'N'])->default('N');
            $table->unsignedInteger('id_perm_tipo_rota');
            $table->foreign('id_perm_tipo_rota')->references('id')->on('perm_tipo_rota');
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
        Schema::dropIfExists('rota');
    }
}
