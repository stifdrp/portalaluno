<?php

namespace App\Http\Controllers\Aluno;

use App\DocumentoDisponivel;
use App\Formulario;
use App\RespostaTemplate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AlunoSolicitacaoDocumentoController extends Controller
{

    public function create()
    {
        $aluno_session = Session::get('perfil_aluno');
        // .env com dados referentes ao formulário solicitação de documentos
        $solicitacao_documentos_id = getenv('FORM_DOCUMENTOS');
        // retornar o formulário mais recente para este tipo
        $solicitacao_documentos = Formulario::find($solicitacao_documentos_id);
        $documentos_disponiveis = DocumentoDisponivel::select()
            ->where('formulario_id', $solicitacao_documentos_id)
            ->get();
        $respostas = RespostaTemplate::where('formulario_id', $solicitacao_documentos_id)
            ->where('status', true)
            ->get();
        $tipos_respostas = RespostaTemplate::tipos_respostas();
        return view(
            'solicitacao_documentos.alunos.index',
            compact(
                'solicitacao_documentos',
                'documentos_disponiveis',
                'respostas',
                'tipos_respostas',
                'aluno_session',
            )
        );
    }

    public function store(Request $request)
    {
        dd($request);
    }
}
