<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EnviarPedidoController;
use Illuminate\Http\Request;
use App\Pedido;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Datatables;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::select('*')
            ->where('data_hora_resposta', null)
            ->orderBy('data_hora_abertura')
            ->paginate(30);

        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show(Pedido $pedido)
    {
        if (!empty($pedido->data_hora_resposta)) {
            return redirect()->route('admin.pedidos.index')->withErrors('Pedido já finalizado!');
        }

        if ($pedido) {
            return view('admin.pedidos.show', compact('pedido'));
        }
    }


    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $pedido = Pedido::find($request->pedido_id);
            $pedido->data_hora_resposta = Carbon::parse(now())->format('Y-m-d H:i:s');
            $pedido->corpo_resposta_finalizacao = $request->resposta_corpo;
            $pedido->codpes_func = Auth::user()->username;
            $pedido->save();

            $pedido_controller = new EnviarPedidoController();
            if ($pedido_controller->ship_finalizacao($pedido->id, $request->email_destino)) {
                DB::commit();
                return redirect()->route('admin.pedidos.index')->with('success', 'Pedido finalizado com sucesso!');
            } else {
                DB::rollBack();
                return redirect()->back()->withErrors('Não foi possível finalizar o pedido!');
            }
        } catch (PDOException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
