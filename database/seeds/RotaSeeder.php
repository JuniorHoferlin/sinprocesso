<?php

use App\Models\Rota;
use App\Models\TipoRota;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class RotaSeeder extends Seeder
{

    public function run()
    {
        $json = File::get(base_path('database/seeds/data/permissoes.json'));
        $permissoes = json_decode($json, true);
        Cache::forget('rotas');

        foreach ($permissoes as $permissao) {
            $tipo = TipoRota::where('descricao', $permissao['tipo'])->first();
            if (!$tipo) {
                dd('O tipo da rota (' . $permissao['tipo'] . ') não existe no banco.');
            }

            $permissao['id_perm_tipo_rota'] = $tipo->id;
            unset($permissao['tipo']);
            $achou = Rota::where('rota', $permissao['rota'])->first();
            if (!$achou) {
                Rota::create($permissao);
            } else {
                $achou->update($permissao);
            }
        }
    }
}