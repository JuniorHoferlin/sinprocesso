<?php

namespace App\Services\Crud;

use File;

class CriaViews
{

    protected $routeAs;

    protected $titulo;

    protected $tabela;

    protected $camposForm;

    protected $colunas;

    protected $templates = [
        'index'         => 'app/Console/Commands/CreateCrud/index.txt',
        'adicionar'     => 'app/Console/Commands/CreateCrud/adicionar.txt',
        'alterar'       => 'app/Console/Commands/CreateCrud/alterar.txt',
        'imprimir'      => 'app/Console/Commands/CreateCrud/imprimir.txt',
        'campo'         => 'app/Console/Commands/CreateCrud/campo.txt',
        'campos_filtro' => 'app/Console/Commands/CreateCrud/campo_filtro.txt',
        'form'          => 'app/Console/Commands/CreateCrud/form.txt',
        'listagem'      => 'app/Console/Commands/CreateCrud/listagem.txt',
    ];

    /**
     * Cria as views para o comando create-crud.
     *
     * @param string $tabela
     * @param string $titulo
     * @param string $routeAs
     * @param string $campos
     * @param string $colunas
     */
    public function criar($tabela, $titulo, $routeAs, $campos, $colunas)
    {
        $this->tabela = $tabela;
        $this->titulo = $titulo;
        $this->routeAs = $routeAs;
        $this->camposForm = $campos;
        $this->colunas = $colunas;

        // Cria a pasta
        File::makeDirectory(base_path('resources/views/' . $tabela));

        $this->criarViewComum('adicionar');
        $this->criarViewComum('alterar');
        $this->criarViewComum('imprimir');
        $this->viewIndex();
        $this->viewFormulario();
        $this->viewListagem();
    }

    /**
     * Cria uma view comum.
     *
     * @param string $nome Nome da view.
     */
    public function criarViewComum($nome)
    {
        $view = File::get(base_path($this->templates[$nome]));
        $view = str_replace('[{tabela}]', $this->tabela, $view);
        $view = str_replace('[{titulo}]', $this->titulo, $view);
        $view = str_replace('[{route_as}]', $this->routeAs, $view);
        File::put(base_path('resources/views/' . $this->tabela . "/$nome.blade.php"), $view);
    }

    /**
     * Cria a view index.
     */
    private function viewIndex()
    {
        if (count($camposDefinidos = array_map('trim', explode(';', $this->camposForm))) > 0) {
            $campoFiltro = File::get(base_path($this->templates['campos_filtro']));
            $index = File::get(base_path($this->templates['index']));
            $stringCampos = "";
            foreach ($camposDefinidos as $c) {
                if (count($c_ = array_map('trim', explode(':', $c))) == 2) {
                    $stringCampos .= $campoFiltro;
                    $stringCampos = str_replace('[{campo}]', $c_[0], $stringCampos);
                    $stringCampos = str_replace('[{label}]', $c_[1], $stringCampos);
                } else {
                    echo "#FILTRO# Campo {$c} ignorado, por nao estar descrito corretamente... forma correta -> campo:label\n";
                }
            }

            $index = str_replace('[{campos_formulario_filtro}]', $stringCampos, $index);
            $index = str_replace('[{route_as}]', $this->routeAs, $index);
            $index = str_replace('[{tabela}]', $this->tabela, $index);
            $index = str_replace('[{titulo}]', $this->titulo, $index);
            File::put(base_path('resources/views/' . $this->tabela . "/index.blade.php"), $index);
        }
    }

    /**
     * Cria a view do formulario.
     */
    private function viewFormulario()
    {
        if (count($camposDefinidos = array_map('trim', explode(';', $this->camposForm))) > 0) {
            $campo_formulario = File::get(base_path($this->templates['campo']));
            $form = File::get(base_path($this->templates['form']));
            $stringCampos = "";
            foreach ($camposDefinidos as $c) {
                if (count($c_ = array_map('trim', explode(':', $c))) == 2) {
                    $stringCampos .= $campo_formulario;
                    $stringCampos = str_replace('[{campo}]', $c_[0], $stringCampos);
                    $stringCampos = str_replace('[{label}]', $c_[1], $stringCampos);
                    $stringCampos = str_replace('[{tabela}]', $this->tabela, $stringCampos);
                } else {
                    echo "#FORMULARIO# Campo {$c} ignorado, por nao estar descrito corretamente... forma correta -> campo:label\n";
                }
            }

            $form = str_replace('[{campos_formulario}]', $stringCampos, $form);
            $form = str_replace('[{route_as}]', $this->routeAs, $form);
            $form = str_replace('[{tabela}]', $this->tabela, $form);
            File::put(base_path('resources/views/' . $this->tabela . "/form.blade.php"), $form);
        }
    }

    /**
     * Cria a view de listagem.
     */
    private function viewListagem()
    {
        if (count($camposDefinidos = array_map('trim', explode(';', $this->colunas))) > 0) {
            $listagem = File::get(base_path($this->templates['listagem']));
            $stringHeader = "";
            $stringBody = "";
            foreach ($camposDefinidos as $c) {
                if (count($c_ = array_map('trim', explode(':', $c))) == 2) {
                    $stringHeader .= "<th>" . $c_[1] . "</th>";
                    $stringBody .= '<td>{{ $dado->' . $c_[0] . ' }}</td>';
                } else {
                    echo "#LISTA# Campo {$c} ignorado, por nao estar descrito corretamente... forma correta -> campo:label\n";
                }
            }

            $listagem = str_replace('[{colunas_lista}]', $stringHeader, $listagem);
            $listagem = str_replace('[{colunas_lista_print}]', $stringBody, $listagem);
            $listagem = str_replace('[{route_as}]', $this->routeAs, $listagem);
            File::put(base_path('resources/views/' . $this->tabela . "/listagem.blade.php"), $listagem);
        }
    }

}