<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use PDF;
use Carbon\Carbon;
use ForceUTF8\Encoding;

class CertificadoConclusaoController extends Controller
{
    public function __construct()
    {
        // https://web.emanuellimeira.com.br/php/resolvido-configuracao-de-traducao-para-laravel-setlocale-pt_br/
        setlocale(LC_TIME, 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    }

    //
    public function index()
    {
        return view('certificado_conclusao.index');
    }

    public function show(Request $request)
    {
        /** 
         * Selecionar a última habilitação para cada nusp informado
         * será importante para definir os cursos/habilitações
         * pois tabela VINCULOPESSOAUSP teve de ser 'removida' da query original
         */
        $alunos_nusp = explode(',', str_replace(' ', '', $request->codpes));

        foreach ($alunos_nusp as $aluno) {
            $alunos_cursos = DB::connection('replicado')->
                                            select(DB::raw("SELECT TOP 1 codcur, codhab 
                                                            FROM HABILPROGGR
                                                            WHERE codpes={$aluno}
                                                            ORDER BY dtaini DESC"));
            if ($alunos_cursos) {
                $alunos_curso_habil[$aluno]['codcur'] = $alunos_cursos[0]->codcur;
                $alunos_curso_habil[$aluno]['codhab'] = $alunos_cursos[0]->codhab;
            }
        }
        
        $alunos = DB::connection('replicado')->
                        select(DB::raw("SELECT DISTINCT p.codpes, p.nompesttd as nompes, nommaepes, c.nompaipes, CONVERT(VARCHAR, dtanas, 103) AS dtanas, 
                                            tipdocidf, numdocidf, CONVERT(VARCHAR, dtaexdidf, 103) AS dtaexdidf, 
                                            sglorgexdidf, p.sglest AS estado_rg, --v.codcurgrd, v.codhab,
                                            l.cidloc, l.sglest, c.codlocnas, e.nomest, e.codpas, ps.nompas, p.numdocfmt
                                        FROM PESSOA p INNER JOIN COMPLPESSOA c on (p.codpes = c.codpes)
                                                        -- INNER JOIN VINCULOPESSOAUSP v on (p.codpes = v.codpes)
                                                        INNER JOIN LOCALIDADE l on (l.codloc = c.codlocnas)
                                                        INNER JOIN ESTADO e ON (l.sglest = e.sglest AND e.codpas = l.codpas)
                                                        INNER JOIN PAIS ps ON (ps.codpas = l.codpas)
                                        WHERE p.codpes IN ($request->codpes) --AND v.codcurgrd IS NOT NULL
                                        ORDER BY p.nompesttd "));
        $data_colacao = $request->data_colacao;
        $data_conclusao = $request->data_conclusao;
        $codpes = $request->codpes;
        return view('certificado_conclusao.show', compact('alunos', 'data_colacao', 'codpes', 'data_conclusao', 'alunos_curso_habil'));
    }

    public function showPDF(Request $request)
    {
        // Adicionado extensão no tempo de processamento, pois no server demorou mais e retornou fatal error
        set_time_limit(300);
        /** 
         * Selecionar a última habilitação para cada nusp informado
         * será importante para definir os cursos/habilitações
         * pois tabela VINCULOPESSOAUSP teve de ser 'removida' da query original
         */
        $alunos_nusp = explode(',', str_replace(' ', '', $request->codpes));

        foreach ($alunos_nusp as $aluno) {
            $alunos_cursos = DB::connection('replicado')->
                                            select(DB::raw("SELECT TOP 1 codcur, codhab 
                                                            FROM HABILPROGGR
                                                            WHERE codpes={$aluno}
                                                            ORDER BY dtaini DESC"));
            if ($alunos_cursos) {
                $alunos_curso_habil[$aluno]['codcur'] = $alunos_cursos[0]->codcur;
                $alunos_curso_habil[$aluno]['codhab'] = $alunos_cursos[0]->codhab;
            }
        }

        $alunos = DB::connection('replicado')->
                        select(DB::raw("SELECT DISTINCT p.codpes, p.nompesttd, nommaepes, c.nompaipes, CONVERT(VARCHAR, dtanas, 103) AS dtanas, p.sexpes, 
                                            tipdocidf, numdocidf, CONVERT(VARCHAR, dtaexdidf, 103) AS dtaexdidf, 
                                            sglorgexdidf, p.sglest AS estado_rg,-- v.codcurgrd, v.codhab,
                                            l.cidloc, l.sglest, c.codlocnas, e.nomest, e.codpas, ps.nompas, p.numdocfmt
                                        FROM PESSOA p INNER JOIN COMPLPESSOA c on (p.codpes = c.codpes)
                                                        --INNER JOIN VINCULOPESSOAUSP v on (p.codpes = v.codpes)
                                                        INNER JOIN LOCALIDADE l on (l.codloc = c.codlocnas)
                                                        INNER JOIN ESTADO e ON (l.sglest = e.sglest AND e.codpas = l.codpas)
                                                        INNER JOIN PAIS ps ON (ps.codpas = l.codpas)
                                        WHERE p.codpes IN ($request->codpes) --AND v.codcurgrd IS NOT NULL
                                        ORDER BY p.nompesttd "));
        $data_colacao = Carbon::parse(str_replace('/', '-', $request->data_colacao))->formatLocalized('%d de %B de %Y');//format('Y-m-d');
        $data_conclusao = Carbon::parse(str_replace('/', '-', $request->data_conclusao))->formatLocalized('%d de %B de %Y');//format('Y-m-d');
        $start_html = '<html>
                        <link href="https://fonts.googleapis.com/css?family=Jura|Quicksand|Tajawal" rel="stylesheet">
                        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"><body>';
        $end_html = '</body></html>';
        $cursos = $this->cursos();
        $html = $start_html;
        $i = 0;
        foreach($alunos as $aluno) {
            $data_expedicao = Carbon::parse(str_replace('/', '-', $aluno->dtaexdidf))->formatLocalized('%d de %B de %Y');
            $data_nascimento = Carbon::parse(str_replace('/', '-', $aluno->dtanas))->formatLocalized('%d de %B de %Y');
            $nome = strtoupper(Encoding::fixUTF8($aluno->nompesttd)); 
            $nommae = Encoding::fixUTF8($aluno->nommaepes);
            $nompai = Encoding::fixUTF8($aluno->nompaipes);
            $cidade = Encoding::fixUTF8($aluno->cidloc);
            $estado = Encoding::fixUTF8($aluno->nomest);
            $curso = $alunos_curso_habil[$aluno->codpes]['codcur'];
            $habil = $alunos_curso_habil[$aluno->codpes]['codhab'];
            $pais = Encoding::fixUTF8($aluno->nompas);
            $artigo = ($aluno->sexpes == 'M') ? 'o' :  'a';
            $rg = $aluno->numdocfmt;
            $html .= View::make('certificado_conclusao.showPDF', compact('aluno', 'data_colacao', 'data_expedicao', 
                                                                         'data_nascimento', 'cursos',
                                                                         'nome', 'nommae', 'nompai',
                                                                         'cidade', 'estado', 'artigo', 'pais', 'data_conclusao', 'rg',
                                                                         'curso', 'habil'))->render();
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
        return $pdf->download("certificados_conclusao_curso_{$request->data_colacao}.pdf");
    }

    public function cursos() {
        return [
            81002 => 'Administração',
            81003 => 'Administração',
            81100 => 'Ciências Econômicas',
            81101 => 'Ciências Econômicas',
            81200 => 'Ciências Contábeis',
            81300 => 'Economia Empresarial e Controladoria',
            81301 => 'Economia Empresarial e Controladoria',
        ];
    }
}
