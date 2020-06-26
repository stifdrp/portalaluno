<?php

namespace App\Http\Controllers;

use App\Mail\PedidoSolicitadoEnviado;
use App\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PedidoController extends Controller
{
    //
    /**
     * Ship the given order.
     *
     * @param  Request  $request
     * @param  int  $orderId
     * @return Response
     */
    public function ship($pedidoId, $email_pedido)
    {
        // TODO: verificar como trazer os nomes dos documentos solicitados
        $pedido = Pedido::findOrFail($pedidoId)->with('documentos_disponiveis');
        dd($pedido);
        if ($pedido) {
            // TODO: verificar melhor forma de trazer a resposta, por id do pedido ou pedido obj
            $resposta_padrao =  $pedido->resposta_inicial($pedido->id);
        }

        //$pedido, $resposta_padrao
        Mail::to($email_pedido)->send(new PedidoSolicitadoEnviado($pedido));
        return false;
    }
}
