<?php

namespace App\Providers;

use App\Models\Anexo;
use App\Models\Area;
use App\Models\DocumentoPadrao;
use App\Models\Formulario;
use App\Models\Funcao;
use App\Models\GrupoAcesso;
use App\Models\Rota;
use App\Models\TarefaDocumento;
use App\Models\TermoReferencia;
use App\Models\TipoProcesso;
use App\Models\Usuario;
use App\Observers\AnexoObserver;
use App\Observers\AreaObserver;
use App\Observers\DocumentoPadraoObserver;
use App\Observers\FormularioObserver;
use App\Observers\FuncaoObserver;
use App\Observers\GrupoAcessoObserver;
use App\Observers\RotaObserver;
use App\Observers\TarefaDocumentoObserver;
use App\Observers\TermoReferenciaObserver;
use App\Observers\TipoProcessoObserver;
use App\Observers\UsuarioObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{

    public function boot()
    {
        GrupoAcesso::observe(GrupoAcessoObserver::class);
        Funcao::observe(FuncaoObserver::class);
        DocumentoPadrao::observe(DocumentoPadraoObserver::class);
        TermoReferencia::observe(TermoReferenciaObserver::class);
        Formulario::observe(FormularioObserver::class);
        TipoProcesso::observe(TipoProcessoObserver::class);
        Anexo::observe(AnexoObserver::class);
        TarefaDocumento::observe(TarefaDocumentoObserver::class);
        Rota::observe(RotaObserver::class);
        Usuario::observe(UsuarioObserver::class);
        Area::observe(AreaObserver::class);
    }
}