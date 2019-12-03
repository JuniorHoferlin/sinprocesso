<?php

namespace App\Relatorios;

use App\Models\TipoProcesso;

class TipoProcessoListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Lista de Tipos de processos';

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
    protected $view = 'tipo_processo.imprimir';

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
        $dados = TipoProcesso::with('formulario')->orderBy('id', 'ASC');

        if (!empty($filtros["descricao"])) {
            $dados->where("descricao", "LIKE", "%" . $filtros["descricao"] . "%");
        }

        if (!empty($filtros["requesito"])) {
            $dados->where("requesito", "LIKE", "%" . $filtros["requesito"] . "%");
        }

        if (!empty($filtros["id_formulario"])) {
            $dados->where("id_formulario", $filtros["id_formulario"]);
        }

        if (!empty($filtros["tr"])) {
            $dados->where("tr", $filtros["tr"]);
        }

        if ($paginar) {
            return $dados->paginate($this->porPagina);
        }

        return $dados->get();
    }
}