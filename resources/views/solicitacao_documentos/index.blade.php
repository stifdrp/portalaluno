@extends('adminlte::page')

@section('content')

<div class="container col-md-10">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-fluid">
        <div class="content-header">
            <h3>{{ $solicitacao_documentos->nome }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form" action="" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col">
                    <label for="nome" class="control-label">Título</label>
                    <input class="form-control" id="nome" name="nome" value="{{ $solicitacao_documentos->nome }}" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="inicio" class="control-label">Data inicial</label>
                    <input class="form-control" id="inicio" name="inicio" value="{{\Carbon\Carbon::parse($solicitacao_documentos->inicio)->format('d/m/Y')}}" readonly>
                </div>

                <div class="col">
                    <label for="fim" class="control-label">Data Final</label>
                    <input class="form-control" id="fim" name="fim" value="{{\Carbon\Carbon::parse($solicitacao_documentos->fim)->format('d/m/Y')}}" readonly>
                </div>

                <div class="col">
                    <label for="status" class="col-sm-2 control-label">Status</label>
                    @if ($solicitacao_documentos->status === false)
                        <input class="form-control" id="status" name="status" value="Desativado" readonly>
                    @elseif ($solicitacao_documentos->status === true)
                        <input class="form-control" id="status" name="status" value="Ativo" readonly>
                    @endif
                </div>
            </div>

            <br>
            <div class="card">
                <div class="card-header">
                    Documentos Disponíveis
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush" id="lista_documentos">
                        @foreach($documentos_disponiveis as $key => $documento)
                            <li class="form-group-item form-control">{{ $documento->documento }} ({{ $documento->descricao }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col">
                    <a href="{{ route('admin.formularios.documentos.edit', ['id' => $solicitacao_documentos->id]) }}" class="btn btn-warning">Editar</a>
                    <a href="{{ route('admin.formularios.documentos.index') }}" class="btn btn-default">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
@stop
