<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTermoReferenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('termo_referencia', function (Blueprint $table) {
            $table->string('codigo', 150)->after('id');
            $table->longText('assunto')->after('codigo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('termo_referencia', function (Blueprint $table) {
            $table->dropColumn('codigo');
            $table->dropColumn('assunto');
        });
    }
}
