@extends('adminlte::page')

@section('content')

<div class="container col-md-10">
    @if ($errors->any())
    <div class="col-6">
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>
                    {{ $error }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </li>
                @endforeach
            </ul>
        </div>
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
                @if (Auth::user()->perfil === 'Funcionario')
                <strong>Perfil do aluno (acesso simulado por funcionário)</strong>
                @endif
                @if (Auth::user()->perfil === 'Aluno')
                <strong>Meus dados</strong>
                @endif
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
            @if (Auth::user()->perfil === 'Funcionario')
            <input type="hidden" name="aluno_codpes" value="{{ $aluno_session->codpes }}">
            @endif
            @if (Auth::user()->perfil === 'Aluno')
            <input type="hidden" name="aluno_codpes" value="{{ Auth::user()->username }}">
            @endif
            <div class="row">
                <div class="col">
                    <label for="nome" class="control-label">Título</label>
                    <input class="form-control" id="nome" name="nome" value="{{ $solicitacao_documentos->nome }}" readonly>
                </div>

                <div class="col">
                    <label for="data_hora_abertura" class="control-label">Data/Horário pedido:</label>
                    <input class="form-control" id="data_hora_abertura" name="data_hora_abertura" value="{{\Carbon\Carbon::now()->format('d/m/Y H:i:s')}}" readonly>
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
                                @if (!empty(old('documento_solicitado')))
                                @if (in_array($documento->id, old('documento_solicitado')))
                                <input type="checkbox" name="documento_solicitado[]" value="{{ $documento->id }}" checked>
                                @else
                                <input type="checkbox" name="documento_solicitado[]" value="{{ $documento->id }}">
                                @endif
                                @else
                                <input type="checkbox" name="documento_solicitado[]" value="{{ $documento->id }}">
                                @endif
                                {{ $documento->documento }} ({{ $documento->descricao }})
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <strong>Finalidade/Observações (preenchimento obrigatório)</strong>
                </div>

                <div class="card-body">
                    <textarea class="form-control" rows="4" name="justificativa" required>{{ old('justificativa') }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('home') }}" class="btn btn-default">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
@stop
