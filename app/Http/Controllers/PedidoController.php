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
        $pedido = Pedido::findOrFail($pedidoId);
        //if ($pedido) {
        //// TODO: verificar melhor forma de trazer a resposta, por id do pedido ou pedido obj
        //$resposta_padrao =  $pedido->resposta_inicial($pedido->id);
        //}

        //return (new PedidoSolicitadoEnviado($pedido))->render();
        Mail::to($email_pedido)->send(new PedidoSolicitadoEnviado($pedido));

        if (Mail::failures()) {
            return false;
        }

        return redirect()->back()->with('success', 'E-mail enviado com sucesso');
    }
}
