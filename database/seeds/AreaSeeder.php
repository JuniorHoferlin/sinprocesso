<?php

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{

    public function run()
    {
        $json = File::get(base_path('database/seeds/data/areas.json'));
        $areas = json_decode($json, true);

        foreach ($areas as $area) {
            $achou = Area::where('descricao', $area['descricao'])->first();
            if (!$achou) {
                Area::create($area);
            } else {
                $achou->update($area);
            }
        }
    }
}