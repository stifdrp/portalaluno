@extends('adminlte::page')

@section('content')

<div class="container col-md-6">
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
            <h3>{{ $solicitacao_documentos->nome }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form" action="{{ route('admin.formularios.documentos.update', ['id' => $solicitacao_documentos->id]) }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col">
                    <label for="nome" class="control-label">Título</label>
                    <input class="form-control" id="nome" name="nome" value="{{ $solicitacao_documentos->nome }}" required autofocus>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="inicio" class="control-label">Data inicial</label>
                    <input class="form-control" id="inicio" name="inicio" value="{{\Carbon\Carbon::parse($solicitacao_documentos->inicio)->format('d/m/Y')}}" required>
                </div>

                <div class="col">
                    <label for="fim" class="control-label">Data Final</label>
                    <input class="form-control" id="fim" name="fim" value="{{\Carbon\Carbon::parse($solicitacao_documentos->fim)->format('d/m/Y')}}">
                </div>

                <div class="col">
                    <label for="status" class="control-label">Status</label>
                    <select class="form-control" name="status">
                      @foreach ($opcoes_status as $status => $nome_status)
                          @if ($solicitacao_documentos->status == $status)
                              <option value="{{ $status }}" selected>{{ $nome_status }}</option>
                          @else
                              <option value="{{ $status }}">{{ $nome_status }}</option>
                          @endif
                      @endforeach
                    </select>
                </div>
            </div>

            <br>
            <div class="card">
                <div class="card-header">
                    Documentos Disponíveis <button type="button" class="btn btn-primary btn-sm" id="documento_add"><i class="far fa-plus-square"></i></button>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush" id="lista_documentos">
                        @foreach($documentos_disponiveis as $key => $documento)
                            <li class="list-group-item">
                                <div class="input-group">
                                    <input type="hidden" class="form-control" name="documentos[id][]" value="{{ $documento->id }}">
                                    <input type="text" class="form-control" name="documentos[nome][]" value="{{ $documento->documento }}" required>
                                    <input type="text" class="form-control" name="documentos[descricao][]" value="{{ $documento->descricao }}" required>
                                    <div class="input-group-append">
                                        <a id="botao_delete" class="btn btn-outline-secondary btn-danger"><i class="fas fa-minus-circle"></i></a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <br>
            <!-- /.box-body -->
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-info">Salvar</button>
                    <a href="{{ route('admin.formularios.documentos.index') }}" class="btn btn-default">Cancelar</a>
                </div>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
</div>
@stop

@section('js')
    <script src="{{ asset('js/documentos.js') }}"></script>
@endsection
