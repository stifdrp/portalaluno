<?php

namespace App\Http\Controllers;

use App\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $aluno_session = Session::get('perfil_aluno');
        $qtde_pedidos_pendentes = Pedido::quantidadePedidosPendentes();
        return view('home', compact('aluno_session', 'qtde_pedidos_pendentes'));
    }
}
