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
</div>

<hr>
@can('admin')
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

@if ($errors->any())
<div class="col-6">
    <div class="alert alert-info">
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
@endcan
@stop
