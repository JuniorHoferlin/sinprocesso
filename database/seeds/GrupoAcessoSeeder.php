<?php

use App\Models\Area;
use App\Models\GrupoAcesso;
use Illuminate\Database\Seeder;

class GrupoAcessoSeeder extends Seeder
{

    public function run()
    {
        $tipos = [
            [
                'descricao'   => 'Admin',
                'super_admin' => 'S'
            ]
        ];

        foreach ($tipos as $dados) {
            $grupo = GrupoAcesso::where('descricao', $dados['descricao'])->first();
            if (!$grupo) {
                $grupo = GrupoAcesso::create($dados);
            } else {
                $grupo->update($dados);
            }

            $areas = [];
            Area::get()->each(function ($area) use (&$areas){
                $areas[] = $area->id;
            });
            $grupo->areas()->syncWithoutDetaching($areas);
        }
    }
}