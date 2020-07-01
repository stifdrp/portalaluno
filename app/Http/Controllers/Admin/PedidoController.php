<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pedido;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::select('*')
            ->where('data_hora_resposta', null)
            ->orderBy('data_hora_abertura')
            ->get();

        return view('admin.pedidos.index', compact('pedidos'));
    }

    // TODO: implementar show Pedido para mostrar o pedido completo
    // e dar opção para responder
    public function show(Pedido $pedido)
    {
        return view('admin.pedidos.show', compact('pedido'));
    }
}
