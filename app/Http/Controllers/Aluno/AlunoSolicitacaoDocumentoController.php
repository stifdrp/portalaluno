<?php

namespace App\Http\Controllers\Aluno;

use App\Aluno;
use App\DocumentoDisponivel;
use App\DocumentoSolicitado;
use App\Formulario;
use App\RespostaTemplate;
use App\Http\Controllers\Controller;
use App\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PDOException;

class AlunoSolicitacaoDocumentoController extends Controller
{

    public function create()
    {
        if (Auth::user()->perfil === 'Funcionario') {
            $aluno_session = Session::get('perfil_aluno');
        } else if (Auth::user()->perfil === 'Aluno') {
            $aluno_session = Session::get('dados_aluno');
        }

        if ($aluno_session) {
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
                'solicitacao_documentos.alunos.create',
                compact(
                    'solicitacao_documentos',
                    'documentos_disponiveis',
                    'respostas',
                    'tipos_respostas',
                    'aluno_session',
                )
            );
        } else {
            return redirect()->route('home')->withErrors('Dados de aluno não encontrado!');
        }
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => 'O campo ":attribute" precisa estar preenchido!',
            'min' => 'O campo ":attribute" precisa estar preenchido com pelo menos ":min" caracteres!',
        ];

        $validateData = $request->validate([
            'aluno_codpes' => 'required',
            'documento_solicitado' => 'required',
            'justificativa' => 'required|min:20',
        ], $messages);

        if (Auth::user()->perfil === 'Funcionario') {
            $email_destino = Auth::user()->email;
        } else if (Auth::user()->perfil === 'Aluno') {
            $email_destino = Session::get('dados_aluno')->email_administrativo;
        }

        $aluno = Aluno::find($request->aluno_codpes);

        // estrutura tabela Pedidos
        // id, justificativa, abertura, status, data_hora_resposta, codpes_func, corpo_resposta_finalizacao, aluno_id, formulario_id, aluno_codpes
        $pedido = new Pedido();
        $pedido->data_hora_abertura = $request->data_hora_abertura;
        $pedido->aluno_codpes = $request->aluno_codpes;
        $pedido->aluno_id = $aluno->id;
        $solicitacao_documentos_id = getenv('FORM_DOCUMENTOS');
        $pedido->formulario_id = $solicitacao_documentos_id;

        // TODO verificar melhor forma de salvar o pedido e os documentos solicitados
        // com uso de Transaction
        try {
            $pedido->save();
            // salvar cada documento solicitado
            foreach ($request->documento_solicitado as $documento) {
                $documento_solicitado = new DocumentoSolicitado();
                $documento_solicitado->documento_disponivel_id = $documento;
                $documento_solicitado->pedido_id = $pedido->id;
                $documento_solicitado->save();
            }
            $pedido->enviarEmail($email_destino);
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }
}
