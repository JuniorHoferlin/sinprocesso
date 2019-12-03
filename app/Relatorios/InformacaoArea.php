<?php

namespace App\Relatorios;

use App\Models\Processo;
use DB;

class InformacaoArea extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Processo por área';

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
    protected $view = 'relatorios.informacao_area.imprimir';

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
        $dados = Processo::with(['area', 'tarefas.dados', 'insumos.insumoTermo']);

        if (!empty($filtros['processo'])) {
            $dados->where('id', $filtros['processo'])->orWhere('descricao', 'LIKE', "%{$filtros['processo']}%");
        }

        if (!empty($filtros['status'])) {
            $dados->where('status', $filtros['status']);
        }

        if (!empty($filtros['area'])) {
            $dados->where('id_area', $filtros['area']);
        }

        return $dados->orderBy('id');

    }
}