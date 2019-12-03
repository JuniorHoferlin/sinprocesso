<?php

use App\Models\Estado;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{

    public function run()
    {
        $json = File::get(base_path('database/seeds/data/estados.json'));
        $registros = json_decode($json, true);

        foreach ($registros as $registro) {
            $achou = Estado::find($registro['id']);
            if (!$achou) {
                Estado::create($registro);
            } else {
                $achou->update($registro);
            }
        }
    }
}