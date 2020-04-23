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
        <form class="form-horizontal" action="" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label for="nome" class="col-sm-2 control-label">Título</label>
                    <div class="col-sm-6">
                        <input class="form-control" id="nome" name="nome" value="{{ $solicitacao_documentos->nome }}" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inicio" class="col-sm-2 control-label">Data inicial</label>
                    <div class="col-sm-6">
                        <input class="form-control" id="inicio" name="inicio" value="{{\Carbon\Carbon::parse($solicitacao_documentos->inicio)->format('d/m/Y')}}" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fim" class="col-sm-2 control-label">Data Final</label>
                    <div class="col-sm-6">
                        <input class="form-control" id="fim" name="fim" value="{{\Carbon\Carbon::parse($solicitacao_documentos->fim)->format('d/m/Y')}}" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-6">
                        @if ($solicitacao_documentos->status === false)
                            <input class="form-control" id="status" name="status" value="Desativado" readonly>
                        @elseif ($solicitacao_documentos->status === true)
                            <input class="form-control" id="status" name="status" value="Ativo" readonly>
                        @endif
                    </div>
                </div>
            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <a href="{{ route('admin.formularios.documentos.edit', ['id' => $solicitacao_documentos->id]) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('admin.formularios.documentos.index') }}" class="btn btn-default">Cancelar</a>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
</div>
@stop
