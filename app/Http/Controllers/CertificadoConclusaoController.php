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
                                            sglorgexdidf, p.sglest, v.codcurgrd, cg.cgahortot
                                        FROM PESSOA p INNER JOIN COMPLPESSOA c on (p.codpes = c.codpes)
                                                        INNER JOIN VINCULOPESSOAUSP v on (p.codpes = v.codpes)
                                                        INNER JOIN HABILPROGGR h on (p.codpes = h.codpes AND v.codcurgrd = h.codcur AND v.codhab = h.codhab)
                                                        INNER JOIN CURRICULOGR cg on (v.codcurgrd = cg.codcur AND v.codhab = cg.codhab)
                                        WHERE p.codpes IN ($request->codpes)
                                                AND cg.codcrl LIKE CAST(h.codcur AS VARCHAR) + '%' + 
                                                                    CAST(h.codhab AS VARCHAR) + CAST(FORMAT(h.dtaini, 'yy') AS VARCHAR) + 
                                                                    CASE WHEN DATEPART(mm, h.dtaini) >= 7 THEN '2' ELSE '1' END
                                        ORDER BY v.codcurgrd, p.nompes "));
        $data_colacao = $request->data_colacao;
        $codpes = $request->codpes;
        return view('certificado_conclusao.show', compact('alunos', 'data_colacao', 'codpes'));
    }

    public function showPDF(Request $request)
    {
        dd($request);
    }
 }
