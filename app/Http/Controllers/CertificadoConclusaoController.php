<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use PDF;
use Carbon\Carbon;

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
        $data_colacao = Carbon::parse($request->data_colacao)->format('Y-m-d');
        $start_html = '<html><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"><body>';
        $end_html = '</body></html>';
        $cursos = $this->cursos();
        $html = $start_html;
        $i = 0;
        foreach($alunos as $aluno) {
            $data_expedicao = Carbon::parse(str_replace('/', '-', $aluno->dtaexdidf))->format('Y-m-d');
            $data_nascimento = Carbon::parse(str_replace('/', '-', $aluno->dtanas))->format('Y-m-d');
            $html .= View::make('certificado_conclusao.showPDF', compact('aluno', 'data_colacao', 'data_expedicao', 'data_nascimento', 'cursos'))->render();
            // Se não for o último aluno, adiciona uma quebra de página
            if ($i != count($alunos) - 1) {
                $html .= '<div class="page-break"></div>';
            }
            $i++;
        }
        $html .= $end_html;
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'images' => true,
        ]);

        $pdf = PDF::loadHTML($html);
        return $pdf->download();

        // $pdf->output();
        // $dom_pdf = $pdf->getDomPDF();

        // return $pdf->download();
        // return view('certificado_conclusao.show', compact('alunos', 'data_colacao', 'codpes'));
        // dd($request);
    }

    public function cursos() {
        return [
            81002 => 'Administração',
            81003 => 'Administração',
            81100 => 'Economia',
            81101 => 'Economia',
            81200 => 'Ciências Contábeis',
            81300 => 'Economia Empresarial e Controladoria',
            81301 => 'Economia Empresarial e Controladoria',
        ];
    }

 }
