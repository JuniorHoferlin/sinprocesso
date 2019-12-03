<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnexoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anexo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo', 300);
            $table->string('anexo', 500)->nullable();
            $table->unsignedInteger('id_processo');
            $table->timestamps();

            $table->foreign('id_processo')->references('id')->on('processo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('anexo');
    }
}
