<?php

use App\Models\TipoRota;
use Illuminate\Database\Seeder;

class TipoRotaSeeder extends Seeder
{

    public function run()
    {
        $tipos = [
            'Dashboard',
            'Tipos de Rotas',
            'Rotas',
            'Grupos de Acesso',
            'Feriados',
            'Áreas',
            'Tipos de Regras',
            'Insumos',
            'Tipos de Processos',
            'Termos de Referência',
            'Funções',
            'Usuários',
            'Documento Padrão',
            'Tarefas',
            'Formulários',
            'Processos',
            'Processos - Tarefas',
            'Processos - Especial',
            'Auditoria',
            'Modalidades',
            'Relatórios',
            'Suporte',
        ];

        foreach ($tipos as $descricao) {
            $dados = ['descricao' => $descricao];
            $achou = TipoRota::where('descricao', $descricao)->first();
            if (!$achou) {
                TipoRota::create($dados);
            } else {
                $achou->update($dados);
            }
        }

    }
}