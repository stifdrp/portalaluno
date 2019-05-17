@extends('adminlte::page')

@section('content')

<div class="col-md-8">
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
            <h3 class="box-title">Emissão de Certificado de Conclusão de Curso</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="{{ route('certificado_conclusao.show') }}" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label for="codpes" class="col-sm-2 control-label">Números USP</label>
                    <div class="col-sm-10">
                        <textarea rows="3" class="form-control" id="codpes" name="codpes" autofocus required placeholder="Insira os números USP serados por vírgula"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="data_colacao" class="col-sm-2 control-label">Data Colação</label>
                    <div class="col-sm-4">
                        <input class="form-control" id="data" name="data_colacao" value="{{\Carbon\Carbon::parse(now())->format('d/m/Y')}}" required>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-info">Gerar listagem de alunos</button>
                    <!-- <input type="button" onclick="log();" class="btn btn-info" value="Checar informações" /> -->
                    <a href="{{ route('certificado_conclusao.index') }}" class="btn btn-default">Cancelar</a>
                </div>
                <!-- /.box-footer -->
            </div>
        </form>
    </div>
</div>

<script>
    function log() {
        console.log('oi');
    }
</script>
@stop