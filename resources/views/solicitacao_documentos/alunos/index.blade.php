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
        <!--Meus dados-->
        @if ($aluno_session)
        <div class="card">
            <div class="card-header">
                <strong>Meus dados</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <ul>
                        <li>
                            <strong>Nome (Número USP): {{ $aluno_session->nompes }} ({{ $aluno_session->codpes }})</strong>
                        </li>
                        <li>Curso: {{ $aluno_session->codigo_curso }} (Habilitação: {{ $aluno_session->codigo_habilitacao }})</li>
                        <li>Email: {{ $aluno_session->email_administrativo }}</li>
                        <li>Telefone: {{ $aluno_session->telefone }}</li>
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- /.box-header -->
        <!-- form start -->
        <form class="form" action="{{ route('aluno.solicitacao_documentos.store')}}" method="POST">
            {{ csrf_field() }}
            <!-- TODO verificar se número USP será recuperado do login ou da session-->
            <input type="hidden" name="codpes" value="{{ Auth::user()->username }}">
            <div class="row">
                <div class="col">
                    <label for="nome" class="control-label">Título</label>
                    <input class="form-control" id="nome" name="nome" value="{{ $solicitacao_documentos->nome }}" readonly>
                </div>

                <div class="col">
                    <label for="data_pedido" class="control-label">Data pedido:</label>
                    <input class="form-control" id="data_pedido" name="data_pedido" value="{{\Carbon\Carbon::now()->format('d/m/Y')}}" readonly>
                </div>
            </div>

            <br>
            <div class="card">
                <div class="card-header">
                    <strong>Documentos Disponíveis</strong>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush" id="lista_documentos">
                        @foreach ($documentos_disponiveis as $key => $documento)
                        <li class="form-group-item form-control">
                            <label>
                                <input type="checkbox" name="documento_solicitado[]" value="{{ $documento->id }}">
                                {{ $documento->documento }} ({{ $documento->descricao }})
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>

            <div class="card">
                <div class="card-header">
                    <strong>Justificativa</strong>
                </div>

                <div class="card-body">
                    <textarea class="form-control" rows="4" name="justificativa" required></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('aluno.solicitacao_documentos.create') }}" class="btn btn-default">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
@stop
