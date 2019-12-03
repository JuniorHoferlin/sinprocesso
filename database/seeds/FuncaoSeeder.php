<?php

use App\Models\Area;
use App\Models\Funcao;
use Illuminate\Database\Seeder;

class FuncaoSeeder extends Seeder
{

    public function run()
    {
        $funcoes = [
            'Admin'
        ];

        foreach ($funcoes as $descricao) {
            $dados = ['descricao' => $descricao];
            $funcao = Funcao::where('descricao', $descricao)->first();
            if (!$funcao) {
                $funcao = Funcao::create($dados);
            } else {
                $funcao->update($dados);
            }


            $areas = Area::all()->pluck('id')->toArray();
            $funcao->areas()->sync($areas);
        }

    }
}