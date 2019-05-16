@extends('adminlte::page')

@section('content')

<div class="form-group">
    <div class="row pull-right">
        <div class="col-sm-4">
            <a href="{{ route('certificado_conclusao.index') }}" class="btn btn-info">NOVO</a>
        </div>
        <div class="col-sm-4">
            <form action="{{ route('certificado_conclusao.showPDF') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" value="{{ $data_colacao }}" name="data_colacao">
                <input type="hidden" value="{{ $codpes }}" name="codpes">
                <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-file-pdf-o"></i>PDF</button>
            </form>
        </div>
        <!-- <div class="col-sm-3">
            <form action="{{ route('certificado_conclusao.index') }}" method="post">
                {{ csrf_field() }}
               <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-file-excel-o"></i>EXCEL</button>
            </form>
        </div> -->
    </div>
</div>
<br>

<div class="box-body">
    <h3 class="text-center">Dados dos alunos</h3>
    <div class="col-sm-12">
        <b>Data colação:</b> {{ $data_colacao }}
        <br>
        <b>Emissão:</b> {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    </div>
    <div id="alunos" class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">
            <div class="col-sm-12">
                <table id="alunos_table" class="table table-bordered table-hover dataTable" role="grid">
                    <thead>
                        <tr role="row">
                            <th class="text-center">NUSP</th>
                            <th class="text-center">Nome</th>
                            <th class="text-center">Filiação</th>
                            <th class="text-center">Data nascimento</th>
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Num. Documento</th>
                            <th class="text-center">Data Expedição</th>
                            <th class="text-center">Curso</th>
                            <th class="text-center">Carga horária</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alunos as $aluno)
                            <tr role="row">
                                <td class="text-center">{{ $aluno->codpes }}</td>
                                @php ($nome = \ForceUTF8\Encoding::fixUTF8($aluno->nompes))
                                <td>{{ $nome }}</td>
                                @php ($nommae = \ForceUTF8\Encoding::fixUTF8($aluno->nommaepes))
                                <!-- Ciências Contábeis mostra filiação completa -->
                                @if ($aluno->codcurgrd == '81200')
                                    @php ($nompai = \ForceUTF8\Encoding::fixUTF8($aluno->nompaipes))
                                    <td>{{ "{$nommae} e {$nompai}" }}</td>
                                @else
                                    <td>{{ $nommae }}</td>
                                @endif
                                <td class="text-center">{{ $aluno->dtanas }}</td>
                                <td class="text-center">{{ $aluno->tipdocidf }}</td>
                                @if(strlen($aluno->numdocidf) == 9) 
                                    <td class="text-center">{{ @vsprintf('%s%s.%s%s%s.%s%s%s-%s', str_split($aluno->numdocidf)) . "/{$aluno->sglorgexdidf}-{$aluno->sglest}" }}</td>
                                @elseif(strlen($aluno->numdocidf) == 8)
                                    <td class="text-center">{{ @vsprintf('%s.%s%s%s.%s%s%s-%s', str_split($aluno->numdocidf)) . "/{$aluno->sglorgexdidf}-{$aluno->sglest}" }}</td>
                                @endif
                                <td class="text-center">{{ $aluno->dtaexdidf }}</td>
                                <td class="text-center">{{ $aluno->codcurgrd }}</td>
                                <td class="text-center">{{ $aluno->cgahortot }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop