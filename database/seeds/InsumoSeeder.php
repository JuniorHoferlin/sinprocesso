<?php

use App\Models\Insumo;
use Illuminate\Database\Seeder;

class InsumoSeeder extends Seeder
{

    public function run()
    {
        $json = File::get(base_path('database/seeds/data/insumos.json'));
        $insumos = json_decode($json, true);

        foreach ($insumos as $insumo) {
            $achou = Insumo::where('produto', $insumo['produto'])->first();
            if (!$achou) {
                Insumo::create($insumo);
            } else {
                $achou->update($insumo);
            }
        }
    }
}