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
            <h3>Documento disponível para formulário: {{ $formulario->first()->nome }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form" action="{{ route('admin.formularios.documentos_disponiveis.store') }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="formulario_id" value="{{ $formulario->first()->id }}"></input>
            <div class="row">
                <div class="col">
                    <label for="nome" class="control-label">Nome documento</label>
                    <textarea rows="2" name="nome" class="form-control" placeholder="Cabeçalho da resposta"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label for="descricao" class="control-label">Descrição documento</label>
                    <textarea rows="4" name="descricao" class="form-control" placeholder="Corpo da resposta"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label for="detalhes_opcionais" class="control-label">Contém detalhes_opcionais?</label>
                    <input type="checkbox" name="detalhes_opcionais">
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('admin.formularios.documentos.index') }}" class="btn btn-default">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
