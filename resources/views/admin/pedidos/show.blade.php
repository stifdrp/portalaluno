@extends('adminlte::page')

@section('content')

<div class="col-12">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- Horizontal Form -->
    <div class="container-fluid">
        <div class="content-header">
            <h3 class="box-title text-center">Finalizar Pedido #{{ $pedido-> id }}</h3>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><strong>{{ $pedido->formulario->nome }} #{{ $pedido-> id }}</strong></h3>
                <br>
                <small>Data e hora: {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pedido->data_hora_abertura)->format('d/m/y H:i:s') }}</small>
            </div>
            <div class="card-body">
                <p><b>Aluna(o):</b> {{ $pedido->aluno->nompes }} ({{ $pedido->aluno->codpes }})</br>
                    <b>Curso:</b> {{ $pedido->aluno->codigo_curso }}-{{ $pedido->aluno->codigo_habilitacao }}</br>
                    <b>E-mail:</b> {{ $pedido->aluno->email_administrativo }}</br>
                    <b>Telefone:</b> {{ $pedido->aluno->telefone }}</p>
                <hr>
                <strong>Documentos Solicitados</strong>
                <ul class="list-group list-group-flush" id="lista_documentos">
                    @foreach ($pedido->documentos_solicitados as $documento)
                    @if (!empty($documento->detalhes_opcionais))
                    <li class="form-group-item form-control">{{ $documento->documento_disponivel->documento }} - {{ $documento->detalhes_opcionais }}</li>
                    @else
                    <li class="form-group-item form-control">{{ $documento->documento_disponivel->documento }}</li>
                    @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!--Documentos solicitados-->
    <!--Resposta do pedido-->
    <form action="{{ route('admin.pedidos.update')}}" method="POST">
        <div class="card">
            <div class="card-header">
                <strong>Resposta do pedido</strong>
            </div>
            <div class="card-body">
                <input type="hidden" name="pedido_id" value="{{ $pedido->id }}">
                <input type="hidden" name="email_destino" value="{{ $pedido->aluno->email_administrativo }}">
                {{ csrf_field() }}
                <div class="col">
                    <label for="inicio" class="control-label">Cabeçalho</label>
                    <input class="form-control" id="inicio" name="resposta_cabecalho" value="{{ $pedido->resposta_final($pedido)->cabecalho }}" disabled>
                </div>

                <div class="col">
                    <label for="inicio" class="control-label">Corpo</label>
                    <textarea class="form-control" rows="6" id="inicio" name="resposta_corpo" required>{{ $pedido->resposta_final($pedido)->corpo }}</textarea>
                </div>

                <div class="col">
                    <label for="inicio" class="control-label">Rodapé</label>
                    <textarea class="form-control" rows="7" id="inicio" name="resposta_rodape" disabled>{{ $pedido->resposta_final($pedido)->rodape }}</textarea>
                </div>
            </div>
        </div>
        <button class="btn btn-primary">Salvar</button>
        <a href="{{ route('admin.pedidos.index') }}" class="btn btn-default">Cancelar</a>
    </form>
</div>
</div>
@stop
