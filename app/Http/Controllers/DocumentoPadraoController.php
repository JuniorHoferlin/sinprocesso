<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarDocumentoPadraoRequest;
use App\Models\DocumentoPadrao;
use App\Relatorios\DocumentoPadraoListagem;
use App\Services\ArquivoUploader;
use File;

class DocumentoPadraoController extends Controller
{

    private $listagem;

    /**
     * @var ArquivoUploader
     */
    private $arquivoUploader;

    public function __construct(DocumentoPadraoListagem $listagem, ArquivoUploader $arquivoUploader)
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

        return view('documento_padrao.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        return view('documento_padrao.adicionar');
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarDocumentoPadraoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarDocumentoPadraoRequest $request)
    {
        $dados = $request->all();

        $anexo = $this->arquivoUploader->upload($dados['anexo'], 'documento_padrao');
        if ($anexo) {
            $documento = DocumentoPadrao::create($dados);
            $documento->update(['anexo' => $anexo]);
            flash("Registro salvo com sucesso.", 'success');
        } else {
            flash("Houve um erro ao salvar o documento, contate o suporte técnico.", 'danger');
        }

        return redirect()->route('documento_padrao.index');
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterar($id)
    {
        $documento = DocumentoPadrao::find($id);

        return view('documento_padrao.alterar', compact('documento'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param int $id
     *
     * @param SalvarDocumentoPadraoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar($id, SalvarDocumentoPadraoRequest $request)
    {
        $documento = DocumentoPadrao::find($id);
        $atualizado = $documento->update($request->except('anexo'));
        if ($atualizado) {
            if (!is_null($request->file('anexo'))) {
                File::delete($documento->anexo);
                $anexo = $this->arquivoUploader->upload($request->file('anexo'), 'documento_padrao');
                $documento->update(['anexo' => $anexo]);
            }

            flash("Os dados do registro foram alterados com sucesso.", 'success');
        }

        return redirect()->route('documento_padrao.index');
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
        $excluido = DocumentoPadrao::find($id)->delete();
        if ($excluido) {
            flash("O registro foi excluído com sucesso.", 'success');
        }

        return redirect()->route('documento_padrao.index');
    }
}
