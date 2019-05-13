<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CertificadoConclusaoController extends Controller
{
    //
    public function index()
    {
        return view('certificado_conclusao.index');
    }

    public function show(Request $request)
    {
        // dd($request);
        $alunos = DB::connection('replicado')->
                        select(DB::raw("SELECT DISTINCT p.codpes, p.nompes, nommaepes, c.nompaipes, CONVERT(VARCHAR, dtanas, 103) AS dtanas, 
                                            tipdocidf, numdocidf, CONVERT(VARCHAR, dtaexdidf, 103) AS dtaexdidf, 
                                            sglorgexdidf, p.sglest, v.codcurgrd, v.codhab
                                        FROM PESSOA p INNER JOIN COMPLPESSOA c on (p.codpes = c.codpes)
                                                        INNER JOIN VINCULOPESSOAUSP v on (p.codpes = v.codpes)
                                        WHERE p.codpes IN ($request->codpes)
                                        ORDER BY p.nompes "));
        $data_colacao = $request->data_colacao;
        $codpes = $request->codpes;
        return view('certificado_conclusao.show', compact('alunos', 'data_colacao', 'codpes'));
    }

    public function showPDF(Request $request)
    {
        dd($request);
    }
 }
