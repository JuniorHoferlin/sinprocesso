<?php

namespace App\Services\Crud;

use File;
use Illuminate\Support\Str;

class CriaRequest
{

    protected $template = 'app/Console/Commands/CreateCrud/request.txt';

    /**
     * Cria o model do CRUD.
     *
     * @param string $tabela
     * @param string $campos
     */
    public function criar($tabela, $campos)
    {
        // Nome da classe em CamelCase
        $classe = ucfirst(Str::camel($tabela));

        if (count($camposDefinidos = array_map('trim', explode(';', $campos))) > 0) {
            $request = File::get(base_path($this->template));

            $rules = "[";
            foreach ($camposDefinidos as $c) {
                if (count($c_ = array_map('trim', explode(':', $c))) == 2) {
                    $rules .= "'{$c_[0]}' => 'required',";
                } else {
                    echo "#REQUEST# Campo {$c} ignorado, por nao estar descrito corretamente... forma correta -> campo:label\n";
                }
            }
            $rules .= "]";

            $request = str_replace('[{rules}]', $rules, $request);
            $request = str_replace('[{tabela_model}]', $classe, $request);
            File::put(base_path('app/Http/Requests/Salvar' . $classe . 'Request.php'), $request);
        }
    }

}