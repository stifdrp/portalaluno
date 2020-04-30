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
            <h3>Resposta template para formulário: {{ $formulario->first()->nome }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form" action="{{ route('admin.formularios.respostas.store') }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="formulario_id" value="{{ $formulario->first()->id }}"></input>
            <div class="row">
                <div class="col">
                    <label for="tipo" class="control-label">Tipo</label>
                    <select class="form-control" name="tipo">
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo['id'] }}">{{ $tipo['nome']}} ({{ $tipo['descricao'] }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="cabecalho_resposta" class="control-label">Cabeçalho da resposta</label>
                    <textarea rows="2" name="corpo_resposta" class="form-control" placeholder="Cabeçalho da resposta"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label for="corpo_resposta" class="control-label">Corpo da resposta</label>
                    <textarea rows="4" name="corpo_resposta" class="form-control" placeholder="Corpo da resposta"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label for="rodape_resposta" class="control-label">Rodapé da resposta</label>
                    <textarea rows="2" name="rodape_resposta" class="form-control" placeholder="Rodapé da resposta"></textarea>
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
