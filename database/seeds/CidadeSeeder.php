<?php

use App\Models\Cidade;
use Illuminate\Database\Seeder;

class CidadeSeeder extends Seeder
{

    public function run()
    {
        $json = File::get(base_path('database/seeds/data/cidades.json'));
        $registros = json_decode($json, true);

        foreach ($registros as $registro) {
            $achou = Cidade::find($registro['id']);
            if (!$achou) {
                Cidade::create($registro);
            } else {
                $achou->update($registro);
            }
        }
    }
}