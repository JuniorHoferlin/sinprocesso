<?php

namespace App\Relatorios;

use App\Models\TipoRota;

class TipoRotaListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Tipos de Rotas';

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
    protected $view = 'tipos_rotas.imprimir';

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
        $tipos = TipoRota::orderBy('descricao', 'ASC');

        if (!empty($filtros['descricao'])) {
            $tipos->where('descricao', 'LIKE', '%' . $filtros['descricao'] . '%');
        }

        if ($paginar) {
            return $tipos->paginate($this->porPagina);
        }

        return $tipos->get();
    }
}