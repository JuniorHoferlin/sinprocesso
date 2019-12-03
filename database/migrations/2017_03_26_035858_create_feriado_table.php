<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeriadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feriado', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data');
            $table->string('titulo', 200);
            $table->enum('tipo', ['ESTADUAL', 'FACULTATIVO', 'FEDERAL'])->default('ESTADUAL');
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
        Schema::drop('feriado');
    }
}
