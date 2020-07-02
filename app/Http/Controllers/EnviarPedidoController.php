<?php

namespace App\Http\Controllers;

use App\Mail\PedidoFinalizadoEnviado;
use App\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EnviarPedidoController extends Controller
{
    /**
     * Envia o e-mail de confirmação ao aluno
     *
     * @param  int  $pedido_id
     * @param  string  $email_destino
     * @return Response
     */
    public function ship_solicitacao($pedidoId, $email_pedido)
    {
        $pedido = Pedido::findOrFail($pedidoId);

        Mail::to($email_pedido)->send(new PedidoSolicitadoEnviado($pedido));

        if (Mail::failures()) {
            return false;
        }

        return redirect()->back()->with('success', 'E-mail enviado com sucesso');
    }

    /**
     * Envia o e-mail de finalizacao(resposta) ao aluno
     *
     * @param  int  $pedido_id
     * @param  string  $email_destino
     * @return Response
     */
    public function ship_finalizacao($pedidoId, $email_pedido)
    {
        $pedido = Pedido::findOrFail($pedidoId);

        Mail::to($email_pedido)->send(new PedidoFinalizadoEnviado($pedido));

        if (Mail::failures()) {
            return false;
        }

        return redirect()->back()->with('success', 'E-mail de finalização enviado com sucesso');
    }
}
