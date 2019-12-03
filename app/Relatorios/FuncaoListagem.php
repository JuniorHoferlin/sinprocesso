<?php

namespace App\Relatorios;

use App\Models\Funcao;

class FuncaoListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Lista de Funções';

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
    protected $view = 'funcoes.imprimir';

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
        $dados = Funcao::with('areas')->orderBy('id', 'ASC');

        if (!empty($filtros["descricao"])) {
            $dados->where("descricao", "LIKE", "%" . $filtros["descricao"] . "%");
        }

        if ($paginar) {
            return $dados->paginate($this->porPagina);
        }

        return $dados->get();
    }
}