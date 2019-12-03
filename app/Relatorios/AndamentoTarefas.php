<?php

namespace App\Relatorios;

use App\Models\TarefaProcesso;
use DB;

class AndamentoTarefas extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Andamento de Tarefas';

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
    protected $view = 'relatorios.andamento_tarefas.imprimir';

    /**
     * Gera os dados.
     *
     * @param array $filtros
     * @param bool $paginar
     * @param int $pagina
     *
     * @return mixed
     */
    public function gerar($filtros, $paginar = true, $pagina = 1)
    {
        $dados = $this->buscarDados($filtros);

        if ($paginar) {
            $dados = $dados->paginate();
        }

        return $dados;
    }

    /**
     * Busca os dados para o relatório.
     *
     * @param array $filtros
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    private function buscarDados($filtros)
    {
        $dados = TarefaProcesso::with('processo', 'dados.area', 'dados.grupoAcessoArea.dadosGrupo', 'ultimoHistorico');

        if (!empty($filtros['tarefa'])) {
            $tarefa = $filtros['tarefa'];
            $dados->whereHas('dados', function ($q) use ($tarefa) {
                $q->where('identificador', $tarefa)->orWhere('descricao', 'LIKE', "%$tarefa%");
            });
        }

        if (!empty($filtros['processo'])) {
            $processo = $filtros['processo'];
            $dados->whereHas('processo', function ($q) use ($processo) {
                $q->where('id', $processo)->orWhere('descricao', 'LIKE', "%$processo");
            });
        }

        if (!empty($filtros['status_p'])) {
            $status = $filtros['status_p'];
            $dados->whereHas('processo', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        if (!empty($filtros['status_t'])) {
            $status = $filtros['status_t'];
            $dados = $dados->whereHas('ultimoHistorico', function ($q) use ($status) {
                $q->where('situacao', $status);
            });
        }

        return $dados->orderBy('id_processo', 'ASC');
    }
}