<?php

use App\Models\TipoCampo;
use Illuminate\Database\Seeder;

class TipoCampoSeeder extends Seeder
{

    public function run()
    {
        $json = File::get(base_path('database/seeds/data/tipos_campos.json'));
        $registros = json_decode($json, true);

        foreach ($registros as $registro) {
            $achou = TipoCampo::where('descricao', $registro['descricao'])->first();
            if (!$achou) {
                TipoCampo::create($registro);
            } else {
                $achou->update($registro);
            }
        }
    }
}