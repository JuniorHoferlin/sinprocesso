<?php

namespace App\Services\Crud;

use File;
use Illuminate\Support\Str;

class CriarRelatorio
{

    protected $template = 'app/Console/Commands/CreateCrud/relatorio.txt';

    /**
     * Cria o model do CRUD.
     *
     * @param string $titulo
     * @param string $tabela
     * @param string $campos
     */
    public function criar($titulo, $tabela, $campos)
    {
        // Nome da classe em CamelCase
        $classe = ucfirst(Str::camel($tabela));

        if (!File::isDirectory(base_path('app/Relatorios'))) {
            File::makeDirectory(base_path('app/Relatorios'));
        }

        if (count($camposDefinidos = array_map('trim', explode(';', $campos))) > 0) {
            $relatorio = File::get(base_path($this->template));
            $stringCampos = "";
            foreach ($camposDefinidos as $c) {
                if (count($c_ = array_map('trim', explode(':', $c))) == 2) {
                    $stringCampos .= 'if (!empty($filtros["' . $c_[0] . '"])) { $dados->where("' . $c_[0] . '", "LIKE", "%" . $filtros["' . $c_[0] . '"] . "%"); }';
                } else {
                    echo "#FILTRO_WHERE# Campo {$c} ignorado, por nao estar descrito corretamente... forma correta -> campo:label\n";
                }
            }

            $relatorio = str_replace('[{filtros_if}]', $stringCampos, $relatorio);
            $relatorio = str_replace('[{titulo}]', $titulo, $relatorio);
            $relatorio = str_replace('[{tabela}]', $tabela, $relatorio);
            $relatorio = str_replace('[{tabela_model}]', $classe, $relatorio);
            File::put(base_path('app/Relatorios/' . $classe . 'Listagem.php'), $relatorio);
        }
    }

}