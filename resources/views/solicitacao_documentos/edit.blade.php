@extends('adminlte::page')

@section('content')

<div class="col-md-10">
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
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $solicitacao_documentos->nome }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="{{ route('admin.formularios.documentos.update', ['id' => $solicitacao_documentos->id]) }}" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label for="nome" class="col-sm-2 control-label">Título</label>
                    <div class="col-sm-6">
                        <input class="form-control" id="nome" name="nome" value="{{ $solicitacao_documentos->nome }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inicio" class="col-sm-2 control-label">Data inicial</label>
                    <div class="col-sm-6">
                        <input class="form-control" id="inicio" name="inicio" value="{{\Carbon\Carbon::parse($solicitacao_documentos->inicio)->format('d/m/Y')}}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fim" class="col-sm-2 control-label">Data Final</label>
                    <div class="col-sm-6">
                        <input class="form-control" id="fim" name="fim" value="{{\Carbon\Carbon::parse($solicitacao_documentos->fim)->format('d/m/Y')}}">
                    </div>
                </div>

                <div class="form-group">

                    <label for="status" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-6">
                      <select class="form-control" name="status">
                          @foreach ($opcoes_status as $status => $nome_status)
                              @if ($solicitacao_documentos->status == $key)
                                  <option value="{{ $status }}" selected>{{ $nome_status }}</option>
                              @else
                                  <option value="{{ $status }}">{{ $nome_status }}</option>
                              @endif
                          @endforeach
                      </select>
                    </div>
                </div>
            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-info">Salvar</button>
                <a href="{{ route('admin.formularios.documentos.index') }}" class="btn btn-default">Cancelar</a>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
</div>
@stop
