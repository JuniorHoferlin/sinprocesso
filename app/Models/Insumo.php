<?php

namespace App\Models;

use DB;

class Insumo extends BaseModel
{

    protected $table = 'insumo';

    /**
     * @param int $id ID do termo de referencia.
     *
     * @return mixed
     */
    public static function verificarInsumosAbertos($id)
    {
        // retorna todos os insumos daquele termo
        $insumosTermo = InsumoTermoReferencia::with('insumo', 'termoReferencia.processos.insumos')->where('id_termo_referencia', $id)->get();

        // modifica aqueles insumos para se adequar as regras
        $insumosTermo->transform(function ($insumo) {

            $insumo->comprado = 0;

            // busca os processos daquele termo de referencia em questão que esteja aberto/finalizado
            $processos = $insumo->termoReferencia->processos->filter(function ($processo) {
                return in_array($processo->status, ['ABERTO', 'FINALIZADO']);
            });

            // percorre os processos filtrados
            $processos->each(function ($processo) use (&$insumo) {

                // para o processo atual, busca os insumos e os percorre
                $processo->insumos->each(function ($processoInsumoTermoReferencia) use (&$insumo) {

                    // se o insumo for o mesmo soma a quantidade comprada
                    if ($processoInsumoTermoReferencia->id_insumo_termo_referencia == $insumo->id) {
                        $insumo->comprado = $insumo->comprado + $processoInsumoTermoReferencia->quantidade;
                    }
                });
            });

            $insumo->solicitado = $insumo->quantidade;
            $insumo->restante = $insumo->solicitado - $insumo->comprado;

            return $insumo;
        });

        $insumosTermo = $insumosTermo->filter(function ($insumo) {
            return $insumo->restante > 0;
        });


        return $insumosTermo;
    }

    /**
     * Busca os insumos em tramite dos processos abertos.
     *
     * @param array $periodo
     *
     * @return array
     */
    public static function buscarInsumosEmTramite($periodo)
    {
        $processos = Processo::with('insumos')->where('data_inicio', '>=', $periodo['inicio'])->whereNull('data_fim')->get();

        $quantidades = 0;
        $processos->each(function ($processo) use (&$quantidades) {
            $quantidades = $processo->insumos->sum('quantidade');
        });

        return $quantidades;
    }

}
