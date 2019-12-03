<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormularioCampoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_campo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_formulario');
            $table->unsignedInteger('id_tipo_campo');
            $table->string('label', 255);
            $table->enum('required', ['S', 'N'])->default('N');
            $table->longText('opcoes')->nullable();
            $table->timestamps();

            $table->foreign('id_formulario')->references('id')->on('formulario');
            $table->foreign('id_tipo_campo')->references('id')->on('tipo_campo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('formulario_campo');
    }
}
