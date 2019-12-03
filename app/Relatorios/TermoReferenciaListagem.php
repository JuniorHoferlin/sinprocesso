<?php

namespace App\Relatorios;

use App\Models\TermoReferencia;

class TermoReferenciaListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Lista de Termos de Referência';

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
    protected $view = 'termo_referencia.imprimir';

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
        $dados = TermoReferencia::orderBy('id', 'ASC');

        if (!empty($filtros["codigo"])) {
            $dados->where("codigo", "LIKE", "%" . $filtros["codigo"] . "%");
        }

        if (!empty($filtros["diretoria"])) {
            $dados->where("diretoria", "LIKE", "%" . $filtros["diretoria"] . "%");
        }

        if (!empty($filtros["fonte_recurso"])) {
            $dados->where("fonte_recurso", "LIKE", "%" . $filtros["fonte_recurso"] . "%");
        }

        if (!empty($filtros["classificacao_orcamento"])) {
            $dados->where("classificacao_orcamento", "LIKE", "%" . $filtros["classificacao_orcamento"] . "%");
        }

        if (!empty($filtros["natureza_despesa"])) {
            $dados->where("natureza_despesa", "LIKE", "%" . $filtros["natureza_despesa"] . "%");
        }

        if (!empty($filtros["bloco"])) {
            $dados->where("bloco", "LIKE", "%" . $filtros["bloco"] . "%");
        }

        if (!empty($filtros["componente"])) {
            $dados->where("componente", "LIKE", "%" . $filtros["componente"] . "%");
        }

        if (!empty($filtros["acao"])) {
            $dados->where("acao", "LIKE", "%" . $filtros["acao"] . "%");
        }

        if (!empty($filtros["programa_ppa"])) {
            $dados->where("programa_ppa", "LIKE", "%" . $filtros["programa_ppa"] . "%");
        }

        if (!empty($filtros["ata_regristro_preco"])) {
            $dados->where("ata_regristro_preco", "LIKE", "%" . $filtros["ata_regristro_preco"] . "%");
        }

        if ($paginar) {
            return $dados->paginate($this->porPagina);
        }

        return $dados->get();
    }
}