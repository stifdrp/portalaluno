<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DocumentoDisponivelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Formulario;
use App\DocumentoDisponivel;
use App\RespostaTemplate;

class SolicitacaoDocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // .env com dados referentes ao formulário solicitação de documentos
        $solicitacao_documentos_id = getenv('FORM_DOCUMENTOS');
        // retornar o formulário mais recente para este tipo
        $solicitacao_documentos = Formulario::find($solicitacao_documentos_id);
        $documentos_disponiveis = DocumentoDisponivel::where('formulario_id', $solicitacao_documentos_id)
            ->where('status', true)
            ->orderBy('documento')
            ->get();
        $respostas = RespostaTemplate::where('formulario_id', $solicitacao_documentos_id)
            ->where('status', true)
            ->get();
        $tipos_respostas = RespostaTemplate::tipos_respostas();
        // Retornar o form para preenchimento do funcionário
        return view('solicitacao_documentos.index', compact(
            'solicitacao_documentos',
            'documentos_disponiveis',
            'respostas',
            'tipos_respostas'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $opcoes_status = ["false" => 'Desativado', "true" => 'Ativo'];
        // retornar o formulário mais recente para este tipo
        $solicitacao_documentos = Formulario::find($id);
        $documentos_disponiveis = DocumentoDisponivel::where('formulario_id', $id)
            ->orderBy('status')
            ->orderBy('documento')
            ->get();
        $respostas = RespostaTemplate::where('formulario_id', $id)
            ->get();
        $tipos_respostas = RespostaTemplate::tipos_respostas();
        // Retornar o form para preenchimento do funcionário
        return view('solicitacao_documentos.edit', compact(
            'solicitacao_documentos',
            'opcoes_status',
            'documentos_disponiveis',
            'respostas',
            'tipos_respostas'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // TODO: melhorar aqui, ao editar a solicitacao_documentos
        // a opção de Ativo/Desativado
        // Garantir que se os documentos forem alterados,
        // caso existem alterações, elas foram concluídas com sucesso
        $docs_ok = true;
        if ((!empty($request->documentos)) && (count($request->documentos) > 0)) {
            $documento_disponivel = new DocumentoDisponivelController();
            $docs_ok = $documento_disponivel->update($request);
        }

        $respostas_ok = true;
        if ((!empty($request->respostas)) && (count($request->respostas) > 0)) {
            $resposta_template = new RespostaTemplateController();
            $respostas_ok = $resposta_template->update($request, $id);
        }

        $messages = [
            'required' => 'O campo :attribute deve estar preenchido.',
            'max' => 'O limite de caracteres foi atingindo.',
        ];

        // Componente responsável pela validação
        $validator = Validator::make($request->all(), [
            'nome' => 'required|max:128',
            'inicio' => 'required',
            'status' => 'required',
        ], $messages);

        // Validação
        if ($validator->fails()) {
            return redirect()
                ->route('admin.formularios.documentos.edit', ['id' => $id])
                ->withErrors($validator)
                ->withInput();
        }

        $formulario_documento = Formulario::find($id);
        $formulario_documento->nome = $request->nome;
        $formulario_documento->inicio = Carbon::createFromFormat('d/m/Y', $request->inicio);
        $formulario_documento->fim = Carbon::createFromFormat('d/m/Y', $request->fim);
        $formulario_documento->status = $request->status;

        $formulario_documento->save();


        return redirect()->route('admin.formularios.documentos.index');
    }
}
