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
                    @if (isset($solicitacao_documentos->fim) && !is_null($solicitacao_documentos->fim))
                        <input class="form-control" id="fim" name="fim" value="{{\Carbon\Carbon::parse($solicitacao_documentos->fim)->format('d/m/Y')}}">
                    @else
                        <input class="form-control" id="fim" name="fim">
                    @endif
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
            <div class="accordion">
                <div class="card">
                    <div class="card-header" id="cabecalhoDoc">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseDocumentos" id="button_documento_add">
                            Documentos Disponíveis
                        </button>
                        <a href="{{ route('admin.formularios.documentos_disponiveis.create', ['formulario_id' => $solicitacao_documentos->id])}}" type="button" class="btn btn-primary btn-sm" id="resposta_add"> <i class="far fa-plus-square"></i> Documentos Disponíveis </a>
                    </div>
                    <div id="collapseDocumentos" class="collapse show">
                        <div class="card-body">
                            <ul class="list-group list-group-flush" id="lista_documentos">
                                @foreach($documentos_disponiveis as $key => $documento)
                                @if ($documento->status == '1')
                                <li class="list-group-item">
                                    @else
                                <li class="list-group-item" style="text-decoration: line-through">
                                    @endif
                                    <div class="input-group">
                                        <input type="hidden" class="form-control" name="documentos[id][]" value="{{ $documento->id }}">
                                        <input type="text" class="form-control" name="documentos[nome][]" value="{{ $documento->documento }}" required>
                                        <input type="text" class="form-control" name="documentos[descricao][]" value="{{ $documento->descricao }}" required>
                                        <div class="form-check">
                                            @if ($documento->status == '1')
                                            <input class="form-check-input" type="checkbox" value="{{ $documento->id }}" id="checkbox_{{ $documento->id }}" name="documentos[ativo][]" checked="checked">
                                            @elseif ($documento->status == '0')
                                            <input class="form-check-input" type="checkbox" value="{{ $documento->id }}" id="checkbox_{{ $documento->id }}" name="documentos[ativo][]">
                                            @endif
                                            <label class="form-check-label" for="checkbox_{{ $documento->id }}">Ativado</label>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="cabecalhoResp">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseRespostas" id="button_resposta_add">
                            Respostas Padrão
                        </button>
                        <a href="{{ route('admin.formularios.respostas.create', ['formulario_id' => $solicitacao_documentos->id])}}" type="button" class="btn btn-primary btn-sm" id="resposta_add"> <i class="far fa-plus-square"></i> Clique para adicionar uma nova</a>
                    </div>
                    <div id="collapseRespostas" class="collapse show">
                        <div class="card-body">
                            @foreach ($respostas as $resposta)
                            @php ($tipo_id = $resposta->tipo)
                            @php ($tipo = (array_filter($tipos_respostas, (fn ($id) => $id == $tipo_id), ARRAY_FILTER_USE_KEY)))
                            <ul class="list-group list-group-flush" id="lista_respostas">
                                @if ($resposta->status == '1')
                                <div class="card">
                                    @elseif ($resposta->status == '0')
                                    <div class="card" style="text-decoration: line-through">
                                        @endif
                                        <div class="card-header">
                                            <div class="form-check">
                                                @if ($resposta->status == '1')
                                                <input class="form-check-input" type="checkbox" value="{{ $resposta->id }}" id="checkbox_{{ $resposta->id }}" name="respostas[ativo][]" checked="checked">
                                                @elseif ($resposta->status == '0')
                                                <input class="form-check-input" type="checkbox" value="{{ $resposta->id }}" id="checkbox_{{ $resposta->id }}" name="respostas[ativo][]">
                                                @endif
                                                <label class="form-check-label" for="checkbox_{{ $resposta->id }}">Ativada</label>
                                                <input type="hidden" name="respostas[id][]" value="{{ $resposta->id }}">
                                            </div>
                                            <strong>Tipo resposta:</strong> {{ $tipo[$tipo_id]['nome'] }} - {{ $tipo[$tipo_id]['descricao'] }}
                                        </div>
                                        <div class="card-footer">
                                            <strong>Título:</strong> {{ $resposta->cabecalho }}
                                        </div>
                                        <div class="card-body">
                                            <label for="inicio" class="control-label">Corpo</label>
                                            <textarea class="form-control" rows="6" id="inicio" name="resposta_corpo" disabled>{{ $resposta->corpo }}</textarea>
                                        </div>
                                        <div class="card-footer">
                                            <strong>Rodapé:</strong><br>
                                            <textarea class="form-control" rows="7" id="inicio" name="resposta_rodape" disabled>{{ $resposta->rodape }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

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
