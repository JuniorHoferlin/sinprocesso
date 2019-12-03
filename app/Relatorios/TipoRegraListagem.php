<?php

namespace App\Relatorios;

use App\Models\TipoRegra;

class TipoRegraListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Tipos de Regras';

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
    protected $view = 'tipo_regra.imprimir';

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
        $tipos = TipoRegra::orderBy('descricao', 'ASC');

        if (!empty($filtros['descricao'])) {
            $tipos->where('descricao', 'LIKE', '%' . $filtros['descricao'] . '%');
        }

        if ($paginar) {
            return $tipos->paginate($this->porPagina);
        }

        return $tipos->get();
    }
}