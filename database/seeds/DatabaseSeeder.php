<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $this->call(EstadoSeeder::class);
            $this->call(CidadeSeeder::class);
            $this->call(TipoCampoSeeder::class);
            $this->call(AreaSeeder::class);
            $this->call(GrupoAcessoSeeder::class);
            $this->call(TipoRotaSeeder::class);
            $this->call(RotaSeeder::class);
            $this->call(FuncaoSeeder::class);
            $this->call(UsuarioSeeder::class);
            $this->call(InsumoSeeder::class);
            $this->call(ModalidadeSeeder::class);
        }
        catch (Exception $e) {
            dd($e->getMessage() . '/' . $e->getLine() . '/' . $e->getFile());
        }
    }
}
