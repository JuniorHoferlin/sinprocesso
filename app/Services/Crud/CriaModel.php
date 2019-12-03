<?php

namespace App\Services\Crud;

use File;
use Illuminate\Support\Str;

class CriaModel
{

    protected $template = 'app/Console/Commands/CreateCrud/model.txt';

    /**
     * Cria o model do CRUD.
     *
     * @param string $tabela
     */
    public function criar($tabela)
    {
        // Nome da classe em CamelCase
        $classe = ucfirst(Str::camel($tabela));

        $model = File::get(base_path($this->template));
        $model = str_replace('[{tabela}]', $tabela, $model);
        $model = str_replace('[{tabela_model}]', $classe, $model);
        File::put(base_path('app/Models/' . $classe . '.php'), $model);
    }

}