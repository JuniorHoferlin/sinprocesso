<?php

use App\Models\Funcao;
use App\Models\GrupoAcesso;
use App\Models\GrupoAcessoArea;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{

    public function run()
    {
        $funcao = Funcao::with('areas')->first();
        $funcaoArea = $funcao->areas->first()->pivot->id;

        $dados = [
            'nome'           => 'Administrador',
            'cpf'            => '000.000.000-00',
            'matricula'      => '000',
            'email'          => 'admin@example.com',
            'status'         => 'Ativo',
            'login'          => 'admin',
            'senha'          => '123', // no model de usuario ele encripta a senha
            'id_funcao_area' => $funcaoArea,
            'id_cidade'      => 1506, // campo grande ms
        ];

        $usuario = Usuario::where('login', $dados['login'])->first();
        if (!$usuario) {
            $usuario = Usuario::create($dados);
        } else {
            $usuario->update($dados);
        }

        $usuario->gruposAcesso()->sync([GrupoAcessoArea::first()->id]);

    }
}