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
            <h3>Simule o acesso de um aluno</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form" action="{{ route('admin.perfil_aluno.store') }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-2">
                    <label for="nusp" class="control-label">Número USP da(o) aluna(o)</label>
                    <input type="text" class="form-control" name="nusp" autofocus>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('home') }}" class="btn btn-default">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
