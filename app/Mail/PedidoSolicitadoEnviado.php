<?php

namespace App\Mail;

use App\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoSolicitadoEnviado extends Mailable
{
    use Queueable, SerializesModels;
    public $pedido;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('lucas@fearp.usp.br')
            ->markdown('emails.pedidos.pedido_solicitado');
    }
}
