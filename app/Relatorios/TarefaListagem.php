<?php

namespace App\Relatorios;

use App\Models\Tarefa;

class TarefaListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Lista de Tarefas';

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
    protected $view = 'tarefas.imprimir';

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
        $dados = Tarefa::naoExclusiva()->with('area')->orderBy('id', 'ASC');

        if (!empty($filtros["titulo"])) {
            $dados->where("titulo", "LIKE", "%" . $filtros["titulo"] . "%");
        }

        if (!empty($filtros["descricao"])) {
            $dados->where("descricao", "LIKE", "%" . $filtros["descricao"] . "%");
        }

        if (!empty($filtros["prazo_minutos"])) {
            $dados->where("prazo_minutos", "LIKE", "%" . $filtros["prazo_minutos"] . "%");
        }

        if (!empty($filtros["tipo"])) {
            $dados->where("tipo", $filtros["tipo"]);
        }

        if ($paginar) {
            return $dados->paginate($this->porPagina);
        }

        return $dados->get();
    }
}