<?php

namespace App\Relatorios;

use App\Models\Usuario;

class UsuarioListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Lista de Usuários';

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
    protected $view = 'usuarios.imprimir';

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
        $dados = Usuario::with('cidade.estado')->orderBy('id', 'ASC');

        if(!session('super_admin')){
            $dados->whereDoesntHave('gruposAcesso', function($q) {
                $q->whereHas('dadosGrupo', function($q) {
                    $q->where('super_admin', 'S');
                });
            });
        }

        if (!empty($filtros["nome"])) {
            $dados->where("nome", "LIKE", "%" . $filtros["nome"] . "%");
        }

        if (!empty($filtros["cpf"])) {
            $dados->where("cpf", "LIKE", "%" . $filtros["cpf"] . "%");
        }

        if (!empty($filtros["email"])) {
            $dados->where("email", "LIKE", "%" . $filtros["email"] . "%");
        }

        if (!empty($filtros["status"])) {
            $dados->where("status", $filtros["status"]);
        }

        if ($paginar) {
            return $dados->paginate($this->porPagina);
        }

        return $dados->get();
    }
}