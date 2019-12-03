<?php

namespace App\Services\Crud;

use File;
use Illuminate\Support\Str;

class CriarController
{

    protected $template = 'app/Console/Commands/CreateCrud/controller.txt';

    protected $templateRotas = 'app/Console/Commands/CreateCrud/rotas.json';

    /**
     * Cria o model do CRUD.
     *
     * @param string $tabela
     * @param string $titulo
     * @param string $routeAs
     */
    public function criar($tabela, $titulo, $routeAs)
    {
        // Nome da classe em CamelCase
        $classe = ucfirst(Str::camel($tabela));

        $controller = File::get(base_path($this->template));
        $controller = str_replace('[{tabela}]', $tabela, $controller);
        $controller = str_replace('[{tabela_model}]', $classe, $controller);
        File::put(base_path('app/Http/Controllers/' . $classe . 'Controller.php'), $controller);

        $this->atualizarRotas($titulo, $routeAs);
    }

    /**
     * Atualiza o arquivo permissoes.json com as novas ações.
     *
     * @param $titulo
     * @param $routeAs
     */
    public function atualizarRotas($titulo, $routeAs)
    {
        $json = File::get(base_path('database/seeds/data/permissoes.json'));
        $rotas = json_decode($json);

        $modelo = File::get(base_path($this->templateRotas));
        $modelo = str_replace('[{titulo}]', $titulo, $modelo);
        $modelo = str_replace('[{route_as}]', $routeAs, $modelo);
        $modelo = json_decode($modelo);

        $rotas = array_merge($rotas, $modelo);
        File::put(base_path('database/seeds/data/permissoes.json'), json_encode($rotas, JSON_UNESCAPED_UNICODE));
    }

}