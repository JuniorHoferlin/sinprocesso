<?php

namespace App\Relatorios;

use App\Models\DocumentoPadrao;

class DocumentoPadraoListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Lista de Documentos Padrão';

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
    protected $view = 'documento_padrao.imprimir';

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
        $dados = DocumentoPadrao::orderBy('id', 'ASC');

        if (!empty($filtros["titulo"])) {
            $dados->where("titulo", "LIKE", "%" . $filtros["titulo"] . "%");
        }

        if (!empty($filtros["descricao"])) {
            $dados->where("descricao", "LIKE", "%" . $filtros["descricao"] . "%");
        }

        if (!empty($filtros["data"])) {
            $dados->where("data", formatarData($filtros["data"], 'Y-m-d'));
        }

        if ($paginar) {
            return $dados->paginate($this->porPagina);
        }

        return $dados->get();
    }
}