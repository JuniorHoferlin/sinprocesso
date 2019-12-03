<?php

use App\Models\Modalidade;
use Illuminate\Database\Seeder;

class ModalidadeSeeder extends Seeder
{

    public function run()
    {
        $modalidades = [
            'Convite',
            'Tomada de preço',
            'Concorrência'
        ];

        foreach ($modalidades as $descricao) {
            $dados = ['descricao' => $descricao];
            $modalidade = Modalidade::where('descricao', $descricao)->first();
            if (!$modalidade) {
                $modalidade = Modalidade::create($dados);
            } else {
                $modalidade->update($dados);
            }
        }
    }
}