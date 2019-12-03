<?php

namespace App\Relatorios;

use App\Models\Rota;

class RotaListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Rotas';

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
    protected $view = 'rotas.imprimir';

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
        $rotas = Rota::with('tipo')->orderBy('descricao', 'ASC');

        if (!empty($filtros['descricao'])) {
            $rotas->where('descricao', 'LIKE', '%' . $filtros['descricao'] . '%');
        }

        if (!empty($filtros['id_perm_tipo_rota'])) {
            $rotas->where('id_perm_tipo_rota', $filtros['id_perm_tipo_rota']);
        }

        if ($paginar) {
            return $rotas->paginate($this->porPagina);
        }

        return $rotas->get();
    }
}