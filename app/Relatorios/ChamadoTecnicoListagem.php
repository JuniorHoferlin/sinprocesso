<?php

namespace App\Relatorios;

use App\Models\ChamadoTecnico;

class ChamadoTecnicoListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Lista de Suporte';

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
    protected $view = 'chamado_tecnico.imprimir';

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
        $dados = ChamadoTecnico::orderBy('created_at', 'DESC');

        if (!empty($filtros["titulo"])) { $dados->where("titulo", "LIKE", "%" . $filtros["titulo"] . "%"); }if (!empty($filtros["descricao"])) { $dados->where("descricao", "LIKE", "%" . $filtros["descricao"] . "%"); }if (!empty($filtros["problema_relatado"])) { $dados->where("problema_relatado", "LIKE", "%" . $filtros["problema_relatado"] . "%"); }if (!empty($filtros["solucao"])) { $dados->where("solucao", "LIKE", "%" . $filtros["solucao"] . "%"); }

        if ($paginar) {
            return $dados->paginate($this->porPagina);
        }

        return $dados->get();
    }
}