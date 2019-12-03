<?php

namespace App\Relatorios;

use App\Models\Feriado;

class FeriadoListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Feriados';

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
    protected $view = 'feriados.imprimir';

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
        $feriados = Feriado::orderBy('data', 'DESC');

        if (!empty($filtros['titulo'])) {
            $feriados->where('titulo', 'LIKE', '%' . $filtros['titulo'] . '%');
        }

        if (!empty($filtros['tipo'])) {
            $feriados->where('tipo', $filtros['tipo']);
        }

        if (!empty($filtros['data'])) {
            $feriados->where('data', formatarData($filtros['data'], 'Y-m-d'));
        }

        if ($paginar) {
            return $feriados->paginate($this->porPagina);
        }

        return $feriados->get();
    }
}