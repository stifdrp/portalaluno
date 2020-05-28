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
        @endif
        <li><a href="#">Trocar perfil aluno</a></li>
    </ul>
</div>
@endcan
@stop
