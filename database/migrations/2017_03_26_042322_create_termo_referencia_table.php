<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermoReferenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('termo_referencia', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('diretoria');
            $table->longText('fonte_recurso');
            $table->longText('classificacao_orcamento');
            $table->longText('natureza_despesa');
            $table->longText('bloco');
            $table->longText('componente');
            $table->longText('acao');
            $table->longText('programa_ppa');
            $table->longText('ata_regristro_preco');
            $table->longText('anexo')->nullable();
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
        Schema::drop('termo_referencia');
    }
}
