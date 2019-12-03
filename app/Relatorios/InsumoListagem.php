<?php

namespace App\Relatorios;

use App\Models\Insumo;

class InsumoListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Insumos';

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
    protected $view = 'insumo.imprimir';

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
        $dados = Insumo::orderBy('produto', 'ASC');

        if (!empty($filtros['produto'])) {
            $dados->where('produto', 'LIKE', '%' . $filtros['produto'] . '%');
        }

        if (!empty($filtros['codigo_produto'])) {
            $dados->where('codigo_produto', 'LIKE', '%' . $filtros['codigo_produto'] . '%');
        }

        if (!empty($filtros['especificacao'])) {
            $dados->where('especificacao', 'LIKE', '%' . $filtros['especificacao'] . '%');
        }

        if (!empty($filtros['unidade'])) {
            $dados->where('unidade', 'LIKE', '%' . $filtros['unidade'] . '%');
        }

        if ($paginar) {
            return $dados->paginate($this->porPagina);
        }

        return $dados->get();
    }
}