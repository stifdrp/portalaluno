<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DocumentoDisponivel;
use App\Formulario;

class DocumentoDisponivelController extends Controller
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
        return view('documentos_disponiveis.create', compact('formulario'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // TODO verificar novo método para salvar os documentos_disponiveis
    // a partir de view própria
    public function store(Request $request)
    {
        // Adicionado transação para possível rollback em caso de problema
        DB::beginTransaction();
        try {
            $documento = new DocumentoDisponivel;
            $documento->status = true;
            $documento->documento = $request->nome;
            $documento->descricao = $request->descricao;
            $documento->formulario_id = $request->formulario_id;
            if (isset($request->detalhes_opcionais) && ($request->detalhes_opcionais == true)) {
                $documento->detalhes_opcionais = true;
            } else {
                $documento->detalhes_opcionais = false;
            }
            $documento->save();
            // Commita a transação
            DB::commit();
            return back()->with('msg', 'Documento Disponível salvo com sucesso');
        } catch (PDOException $e) {
            DB::rollback();
            return back()->withErrors('error', 'Documento Disponível salvo com sucesso');
        }
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
    public function update(Request $request)
    {
        foreach ($request->documentos['nome'] as $key => $nome) {
            $documento = DocumentoDisponivel::find($request->documentos['id'][$key]);
            if (($documento) && (!is_null($documento))) {
                if ((!empty($request->documentos['ativo'])) && (in_array($request->documentos['id'][$key], $request->documentos['ativo']))) {
                    $documento->status = true;
                } else {
                    $documento->status = false;
                }
            }
            $documento->save();
        }
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
