@extends('adminlte::page')

@section('title', 'Graduação')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<div>
    <h4>Meus dados</h4>
    <ul>
        <li><strong>Nome (Número USP): {{ Auth::user()->name }} ({{ Auth::user()->username }})</strong></li>
        <li> {{ Auth::user()->email }}</li>
    </ul>

    @if ($errors->any())
    <div class="col-8 col-sm-8">
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
</div>

@can('admin')
<hr>
<div class="card text-center" style="max-width: 18rem;">
    <h5 class="card-header">Pedidos Pendentes</h5>
    <div class="card-body">
        <h2>{{ $qtde_pedidos_pendentes }}</h2>
        <a href="{{ route('admin.pedidos.index') }}" class="btn btn-primary">Checar</a>
    </div>
</div>
<hr>
<div>
    <div>
        <h4>Dados da aluna(o): </h4>
        <ul>
            @if ($aluno_session)
            <li>
                <strong>Nome (Número USP): {{ $aluno_session->nompes }} ({{ $aluno_session->codpes }})</strong>
            </li>
            <li>Curso: {{ $aluno_session->codigo_curso }} (Habilitação: {{ $aluno_session->codigo_habilitacao }})</li>
            <li>Email: {{ $aluno_session->email_administrativo }}</li>
            <br><a href="{{ route('admin.perfil_aluno.destroy')}}" class="btn btn-outline-danger">Sair do perfil de aluna(o)</a>
            @else
            <a href="{{ route('admin.perfil_aluno.index')}}" class="btn btn-outline-primary">Simular acesso como aluna(o)</a>
            @endif
        </ul>
    </div>
    <!-- Mensagem de retorno que a transação foi salva com sucesso -->
    @if (session()->has('success'))
    <div class="alert alert-success" id="div-sucesso">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ session()->get('success') }}
    </div>
    @endif

    @endcan
    @stop
