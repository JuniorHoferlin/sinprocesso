<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChamadoTecnicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chamado_tecnico', function (Blueprint $table) {
            $table->string('titulo', 300)->after('id');
            $table->dropColumn('data_abertura');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chamado_tecnico', function (Blueprint $table) {
            $table->timestamp('data_abertura')->after('problema_relatado');
            $table->dropColumn('titulo');
        });
    }
}
