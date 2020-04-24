<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Formulario;

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
        // Retornar o form para preenchimento do funcionário
        return view('solicitacao_documentos.index', compact('solicitacao_documentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Retornar o form para preenchimento do funcionário
        // return view('solicitacao_documentos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        // Retornar o form para preenchimento do funcionário
        return view('solicitacao_documentos.edit', compact('solicitacao_documentos', 'opcoes_status'));
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
        $formulario_documento->inicio = $request->inicio;
        $formulario_documento->fim = $request->fim;
        $formulario_documento->status = $request->status;

        $formulario_documento->save();


        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}