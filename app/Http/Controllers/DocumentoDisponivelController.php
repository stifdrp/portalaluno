<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DocumentoDisponivel;
use App\Formulario;

class DocumentoDisponivelController extends Controller
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
        return view('documentos_disponiveis.create', compact('formulario'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $documento = new DocumentoDisponivel;
            $documento->status = true;
            $documento->documento = $request->nome;
            $documento->descricao = $request->descricao;
            $documento->formulario_id = $request->formulario_id;
            $documento->detalhes_opcionais = false;

            if (isset($request->detalhes_opcionais) && ($request->detalhes_opcionais == true)) {
                $documento->detalhes_opcionais = true;
            }
            $documento->save();

            DB::commit();
            return back()->with('msg', 'Documento Disponível salvo com sucesso');
        } catch (PDOException $e) {
            DB::rollback();
            return back()->withErrors('error', 'Documento Disponível salvo com sucesso');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        foreach ($request->documentos['nome'] as $key => $nome) {
            $documento = DocumentoDisponivel::find($request->documentos['id'][$key]);
            $documento->status = false;
            if ((($documento)
                    && (!is_null($documento)))
                && ((!empty($request->documentos['ativo']))
                    && (in_array($request->documentos['id'][$key], $request->documentos['ativo'])))
            ) {
                $documento->status = true;
            }
            $documento->save();
        }
    }
}
