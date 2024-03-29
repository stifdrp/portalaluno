@extends('adminlte::page')

@section('content')

<div class="col-12">
    <!-- Mensagem de retorno que o pedido foi  finalizado com sucesso -->
    @if (session()->has('success'))
    <div class="alert alert-success" id="div-sucesso">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ session()->get('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- Horizontal Form -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title text-center">Finalização de Pedidos</h3>
            <b>Pendentes: </b>{{ $pedidos->total() }}
            <p><small>O filtro de pesquisar funciona apenas na página atual</small></p>
        </div>
        <table class="table table-striped table-sm" id="tabela_pedidos">
            <thead class="thead-dark">
                <th class="text-center">Pedido</th>
                <th class="text-center">Abertura</th>
                <th class="text-center">Aluna (o)</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Finalizar</th>
            </thead>
            @foreach ($pedidos as $pedido)
            <tr>
                <td class="text-center">{{ $pedido->id }}</td>
                <td class="text-center">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pedido->data_hora_abertura)->format('d/m/y H:i:s') }}</td>
                <td>{{ $pedido->aluno->nompes }} ({{ $pedido->aluno->codpes }})</td>
                <td class="text-center">{{ $pedido->formulario->nome }}</td>
                <td class="text-center"><a href="{{ route('admin.pedidos.show', ['pedido' => $pedido]) }}">Finalizar</a></td>
            </tr>
            @endforeach
        </table>
        @if ($pedidos->hasPages())
        <div class="footer">
            <b>Páginas: </b>{{ $pedidos->links() }}
        </div>
        @endif
    </div>
</div>
@stop

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        const table = $('#tabela_pedidos').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json'
            },
            paging: false,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: false,
            autoWidth: true,
        });
    });
</script>
@stop
