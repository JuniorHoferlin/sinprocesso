<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarTermoReferenciaRequest;
use App\Http\Requests\SalvarInsumoTermoReferenciaAddRequest;
use App\Models\Insumo;
use App\Models\InsumoTermoReferencia;
use App\Models\InsumoTermoReferenciaAdd;
use App\Models\ProcessoInsumoTermoReferencia;
use App\Models\TermoReferencia;
use App\Models\Usuario;
use App\Relatorios\TermoReferenciaListagem;
use App\Services\ArquivoUploader;
use File;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Date;

class TermoReferenciaController extends Controller
{

    private $listagem;

    /**
     * @var ArquivoUploader
     */
    private $arquivoUploader;

    public function __construct(TermoReferenciaListagem $listagem, ArquivoUploader $arquivoUploader)
    {
        $this->listagem = $listagem;
        $this->arquivoUploader = $arquivoUploader;
    }

    /**
     * Lista todos os registros do sistema.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $filtros = request()->all();
        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->listagem->exportar($filtros);
        }
        $dados = $this->listagem->gerar($filtros);

        return view('termo_referencia.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @param string $aba
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar($aba = 'detalhes')
    {
        $insumos = Insumo::orderBy('produto', 'ASC')->get();

        return view('termo_referencia.adicionar', compact('insumos', 'aba'));
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarTermoReferenciaRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarTermoReferenciaRequest $request)
    {
        DB::beginTransaction();
        try {
            $dados = $request->all();
            $termoReferencia = TermoReferencia::create($request->except(['insumo']));

            if ($request->get('insumo')) {
                $termoReferencia->insumos()->syncWithoutDetaching(TermoReferencia::prepararRequestParaInsert($request->get('insumo')));
            }

            if ($termoReferencia) {
                $anexo = $this->arquivoUploader->upload($dados['anexo'], 'termo_referencia');
                $termoReferencia->update(['anexo' => $anexo]);
            }

            flash("Registro salvo com sucesso.", 'success');
            DB::commit();

            return redirect()->route('termo_referencia.index');
        } catch (Exception $e) {
            flash("Não foi possivel salvar o registro, contate o suporte técnico.", 'danger');
            DB::rollback();
        }
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterar($id, $aba = 'detalhes')
    {
        $termoReferencia = TermoReferencia::with('insumos')->find($id);

        $adicionados = [];
        $termoReferencia->insumos->each(function ($insumo) use (&$adicionados) {
            $adicionados[] = $insumo->id;
        });

        $termoReferencia->insumos = $termoReferencia->insumos->map(function ($insumo) {
            $insumosEmTramiteProcesso = ProcessoInsumoTermoReferencia::where('id_insumo_termo_referencia', $insumo->pivot->id)->get();
            $insumosAdicionadosPosteriormente = InsumoTermoReferenciaAdd::where('id_insumo_termo_referencia', $insumo->pivot->id)->get();

            if (count($insumosEmTramiteProcesso) > 0) {
                $quantidade = 0;
                foreach ($insumosEmTramiteProcesso as $e) {
                    $quantidade = $quantidade + $e->quantidade;
                }
                $insumo->quantidadeEmProcesso = $quantidade;
            } else {
                $insumo->quantidadeEmProcesso = 0;
            }

            if (count($insumosAdicionadosPosteriormente) > 0) {
                $insumo->adicionadoPosteriormente = 1;
                foreach ($insumosAdicionadosPosteriormente as $i) {
                    $insumo->pivot->quantidade = $insumo->pivot->quantidade + $i->quantidade;
                }
            } else {
                $insumo->adicionadoPosteriormente = 0;
            }

            return $insumo;
        });

        // obtém todos os insumos que não foram adicionados na TR
        $insumos = Insumo::orderBy('produto', 'ASC')->whereNotIn('id', $adicionados)->get();

        return view('termo_referencia.alterar', compact('insumos', 'termoReferencia', 'aba'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param int $id
     *
     * @param SalvarTermoReferenciaRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar($id, SalvarTermoReferenciaRequest $request)
    {
        DB::beginTransaction();
        try {
            $termoReferencia = TermoReferencia::find($id);
            $termoReferencia->update($request->except(['anexo', 'insumo']));

            if (!is_null($request->file('anexo'))) {
                $delete_file = $termoReferencia->anexo;
                $anexo = $this->arquivoUploader->upload($request->file('anexo'), 'termo_referencia');
                $termoReferencia->update(['anexo' => $anexo]);
            }

            if ($request->get('insumo')) {
                $termoReferencia->insumos()->attach(TermoReferencia::prepararRequestParaInsert($request->get('insumo')));
            }

            if (isset($delete_file)) {
                File::delete($delete_file);
            }

            flash("Os dados do registro foram alterados com sucesso.", 'success');
            DB::commit();

            return redirect()->route('termo_referencia.index');
        } catch (Exception $e) {
            flash("Não foi possivel alterar os dados do registro, contate o suporte técnico.", 'danger');
            DB::rollback();
        }
    }

    /**
     * Exclui um registro.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function excluir($id)
    {
        $excluido = TermoReferencia::find($id)->delete();
        if ($excluido) {
            flash("O registro foi excluído com sucesso.", 'success');
        }

        return redirect()->route('termo_referencia.index');
    }

    /**
     * Busca por um termo de referência.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function procurar()
    {
        $id = request('id');
        $termo = TermoReferencia::with('insumos')->where('codigo', $id)->first();
        if (!$termo) {
            $retorno = 0;
        } else {
            $insumosExistentes = Insumo::verificarInsumosAbertos($termo->id);
            if (count($insumosExistentes) > 0) {
                $retorno = 1;
            } else {
                $retorno = 2;
            }
        }

        return response()->json($retorno);
    }

    /**
     * Abre o modal para acrescentar quantidade no insumo.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function acrescentar_insumo()
    {
        $id = request()->input('id');
        $view = view('termo_referencia.acrescentar_insumo', compact('id'))->render();
        return $view;
    }

    /**
     * Adiciona insumos na TR
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function acrescentar_insumo_salvar(SalvarInsumoTermoReferenciaAddRequest $request)
    {
        $added = InsumoTermoReferenciaAdd::create([
            'id_insumo_termo_referencia' => $request->get('id'),
            'id_usuario' => Auth::user()->id,
            'quantidade' => $request->get('quantidade'),
            'motivo' => $request->get('motivo'),
        ]);


        if ($added) {
            $insumoTermoReferencia = InsumoTermoReferencia::with('insumo')->find($added->id_insumo_termo_referencia);
            $view = view('termo_referencia.carregar_insumo_adicionado', compact('insumoTermoReferencia'))->render();
            return json_encode(['status' => 1, 'update' => $insumoTermoReferencia->insumo->id, 'data' => $view]);
        } else {
            return json_encode(['status' => 0, 'errors' => ["Não foi possivel se conectar com o servidor, tente mais tarde."]]);
        }
    }


    /**
     * Retorna a view com a lista de insumos adicionados posteriormente na TR
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ver_insumos_adicionados($id)
    {
        $insumoTermoReferencia = InsumoTermoReferencia::with(['insumo', 'insumoTermoReferenciaAdd'])->find($id);

        Date::setLocale('pt-BR');

        $insumoTermoReferencia->insumoTermoReferenciaAdd = $insumoTermoReferencia->insumoTermoReferenciaAdd->map(function ($insumoTermoReferenciaAdd) {
            $insumoTermoReferenciaAdd->usuario = Usuario::find($insumoTermoReferenciaAdd->id_usuario);
            $insumoTermoReferenciaAdd->dataAcontecimento = Date::createFromFormat('Y-m-d H:i:s', $insumoTermoReferenciaAdd->created_at)->format('l, j F \d\e Y \á\s H\hi');
            return $insumoTermoReferenciaAdd;
        });


        return view('termo_referencia.ver_insumos_adicionados', compact('insumoTermoReferencia'))->render();
    }
}
