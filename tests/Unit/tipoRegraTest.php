<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransaction;
use App\Models\TipoRegra;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class tipoRegraTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $tipoRegra = TipoRegra::make([
            'descricao' => 'Teste Tipo Regra'
        ]);

        $this->assertTrue($tipoRegra->save());
    }
}
