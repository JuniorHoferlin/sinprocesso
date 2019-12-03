<?php

namespace App\Relatorios;

use App\Models\Chamado;

class ChamadoListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Chamados';

    /**
     * Quantidade de itens por página.
     *
     * @var int
     */
    protected $porPagina = 10;

    /**
     * A view utilizada para impressão deste relatório.
     *
     * @var string
     */
    protected $view = 'chamado.imprimir';

    /**
     * Gera os dados.
     *
     * @param array $filtros
     * @param bool $paginar
     *
     * @return mixed
     */
    public function gerar($filtros, $paginar = true)
    {
        $chamados = collect(Chamado::all());

//        if (!empty($filtros['descricao'])) {
//            $areas = $areas->filter(function ($area) use ($filtros) {
//                return stripos($area['text'], $filtros['descricao']) !== false;
//            });
//        }

        return $chamados;
    }
}