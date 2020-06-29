<?php

namespace App\Http\Controllers\Aluno;

use App\Aluno;
use App\DocumentoDisponivel;
use App\DocumentoSolicitado;
use App\Formulario;
use App\RespostaTemplate;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PedidoController;
use App\Pedido;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $documentos_disponiveis = DocumentoDisponivel::select('*')
                ->where('formulario_id', $solicitacao_documentos_id)
                ->orderBy('documento')
                ->get();
            return view(
                'solicitacao_documentos.alunos.create',
                compact(
                    'solicitacao_documentos',
                    'documentos_disponiveis',
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

        DB::beginTransaction();
        try {
            // estrutura tabela Pedidos
            // id, justificativa, abertura, status, data_hora_resposta, codpes_func, corpo_resposta_finalizacao, aluno_id, formulario_id, aluno_codpes
            $pedido = new Pedido();
            $pedido->data_hora_abertura = Carbon::createFromFormat('d/m/Y H:i:s', $request->data_hora_abertura)->format('Y-m-d H:i:s');
            $pedido->aluno_codpes = $request->aluno_codpes;
            $pedido->aluno_id = $aluno->id;
            $pedido->justificativa = $request->justificativa;
            $solicitacao_documentos_id = getenv('FORM_DOCUMENTOS');
            $pedido->formulario_id = $solicitacao_documentos_id;
            $pedido->save();

            // salvar cada documento solicitado
            foreach ($request->documento_solicitado as $documento) {
                $documento_solicitado = new DocumentoSolicitado();
                if (array_key_exists($documento, $request->detalhe_opcional)) {
                    $documento_solicitado->detalhes_opcionais = $request->detalhe_opcional[$documento][0];
                } else {
                    $documento_solicitado->detalhes_opcionais = "";
                }
                $documento_solicitado->documento_disponivel_id = $documento;
                $documento_solicitado->pedido_id = $pedido->id;
                $documento_solicitado->save();
            }

            //if ($pedido->enviarEmail($email_destino)) {
            $pedido_controller = new PedidoController();
            if ($pedido_controller->ship($pedido->id, $email_destino)) {
                DB::commit();
                return redirect()->route('home')->with('success', 'Solicitação de Documentos efetuado com sucesso!');
            } else {
                return back()->withErrors('Não foi possível encaminhar e-mail, por isso, o pedido não foi salvo! Tente novamente!')->withInput();
            }
        } catch (PDOException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
