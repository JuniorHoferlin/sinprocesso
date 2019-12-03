<?php

namespace App\Relatorios;

use App\Models\Area;

class AreaListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Áreas';

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
    protected $view = 'areas.imprimir';

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
        $areas = collect(Area::listarAreasLeveis());

        if (!empty($filtros['descricao'])) {
            $areas = $areas->filter(function ($area) use ($filtros) {
                return stripos($area['text'], $filtros['descricao']) !== false;
            });
        }

        return $areas;
    }
}