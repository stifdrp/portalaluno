<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Formulario;
use App\RespostaTemplate;

class RespostaTemplateController extends Controller
{
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
        ];

        // Componente responsável pela validação
        $validator = Validator::make($request->all(), [
            'tipo' => 'required',
            'cabecalho_resposta' => 'required',
            'corpo_resposta' => 'required',
            'rodape_resposta' => 'required',
        ], $messages);

        // Validação
        if ($validator->fails()) {
            return redirect()
                ->route('admin.formularios.resposta.create', ['id' => $request->formulario_id])
                ->withErrors($validator)->withInput();
        }

        $resposta = new RespostaTemplate();
        $resposta->tipo = $request->tipo;
        $resposta->cabecalho = $request->cabecalho_resposta;
        $resposta->corpo = $request->corpo_resposta;
        $resposta->rodape = $request->rodape_resposta;
        $resposta->formulario_id = $request->formulario_id;
        $resposta->status = true;
        $resposta->save();

        return redirect()->route('admin.formularios.documentos.edit', ['id' => $request->formulario_id]);
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
        // Adicionado transação para possível rollback em caso de problema
        DB::beginTransaction();
        try {
            foreach ($request->respostas['id'] as $key => $id) {
                $resposta = RespostaTemplate::find($id);
                if ((($resposta) && (!is_null($resposta)) && (!empty($request->respostas['ativo']))) && (in_array($request->respostas['id'][$key], $request->respostas['ativo']))) {
                    $resposta->status = true;
                } else {
                    $resposta->status = false;
                }
                $resposta->save();
            }
            // Commita a transação
            DB::commit();
            return true;
        } catch (PDOException $e) {
            DB::rollback();
            return false;
        }
    }
}
