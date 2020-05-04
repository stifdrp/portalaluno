<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Http\Controllers\RespostaTemplateController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Formulario;
use App\RespostaTemplate;

class RespostaTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $id)
    {
        if ($id) {
            $formulario = Formulario::select('id', 'nome')
                                                ->where('id', $id)
                                                ->get();
        }
        $tipos = RespostaTemplate::tipos_respostas();
        return view('resposta_template.create', compact('formulario', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => 'O campo :attribute deve estar preenchido.',
            // 'max' => 'O limite de caracteres foi atingindo.',
        ];

        // Componente responsável pela validação
        $validator = Validator::make($request->all(), [
            // 'nome' => 'required|max:128',
            'tipo' => 'required',
            'cabecalho_resposta' => 'required',
            'corpo_resposta' => 'required',
            'rodape_resposta' => 'required',
        ], $messages);

        // Validação
        if ($validator->fails()) {
            return redirect()
                        ->route('admin.formularios.resposta.create', ['id' => $request->formulario_id])
                        ->withErrors($validator)
                        ->withInput();
        }

        $resposta = new RespostaTemplate();
        $resposta->tipo = $request->tipo;
        $resposta->cabecalho = $request->cabecalho_resposta;
        $resposta->corpo = $request->corpo_resposta;
        $resposta->rodape = $request->rodape_resposta;
        $resposta->formulario_id = $request->formulario_id;
        $resposta->save();

        return redirect()->route('admin.formularios.documentos.edit', ['id' => $request->formulario_id]);
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
        //
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
        //
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
