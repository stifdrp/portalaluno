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
        <form class="form-horizontal" action="{{ 'route_certificado_conclusao.show' }}" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label for="inicio" class="col-sm-2 control-label">Data inicial</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="inicio" name="inicio" value="{{\Carbon\Carbon::parse($solicitacao_documentos->inicio)->format('d/m/Y')}}" required>
                    </div>

                    <label for="fim" class="col-sm-2 control-label">Data Final</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="fim" name="fim" value="{{\Carbon\Carbon::parse($solicitacao_documentos->fim)->format('d/m/Y')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-3">
                      <select class="form-control" name="status">
                          <option value="1">Ativo</option>
                          <option value="0">Desativado</option>
                          @if ($solicitacao_documentos->status === 1)
                              <option value="1" selected>Ativo</option>
                          @endif
                          @if ($solicitacao_documentos->status === 0)
                              <option value="0" selected>Desativado</option>
                          @endif
                      </select>
                    </div>
                </div>

                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-info">Salvar</button>
                    <a href="{{ route('certificado_conclusao.index') }}" class="btn btn-default">Cancelar</a>
                </div>
                <!-- /.box-footer -->
            </div>
        </form>
    </div>
</div>
@stop
