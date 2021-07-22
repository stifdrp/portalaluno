@extends('adminlte::page')

@section('content')
<div class="form-group">
    <div class="row pull-right">
        <div class="col-sm-2">
            <a href="{{ route('certificado_conclusao.index') }}" class="btn btn-info">Nova busca</a>
        </div>
        <div class="col-sm-2">
            <form action="{{ route('certificado_conclusao.showPDF') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" value="{{ $data_colacao }}" name="data_colacao">
                <input type="hidden" value="{{ $data_conclusao }}" name="data_conclusao">
                <input type="hidden" value="{{ $data_documento }}" name="data_documento">
                <input type="hidden" value="{{ $nome_assistente }}" name="nome_assistente">
                <input type="hidden" value="{{ $cargo_assistente }}" name="cargo_assistente">
                <input type="hidden" value="{{ $codpes }}" name="codpes">
                <input type="hidden" value="regular" name="tipo">
                <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-file-pdf"></i>GERAR PDF</button>
            </form>
        </div>
        <div class="col-sm-3">
            <form action="{{ route('certificado_conclusao.showPDF') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" value="{{ $data_colacao }}" name="data_colacao">
                <input type="hidden" value="{{ $data_conclusao }}" name="data_conclusao">
                <input type="hidden" value="{{ $data_documento }}" name="data_documento">
                <input type="hidden" value="{{ $nome_assistente }}" name="nome_assistente">
                <input type="hidden" value="{{ $cargo_assistente }}" name="cargo_assistente">
                <input type="hidden" value="{{ $codpes }}" name="codpes">
                <input type="hidden" value="provisorio" name="tipo">
                <button type="submit" class="btn btn-secondary"><i class="fa fa-fw fa-file-pdf"></i>GERAR PDF Provisório</button>
            </form>
        </div>
    </div>
</div>
<br>

<div class="box-body">
    <h3 class="text-center">Dados dos alunos</h3>
    <div class="col-sm-12">
        <b>Data conclusão:</b> {{ $data_conclusao }}
        <br>
        <b>Data colação:</b> {{ $data_colacao }}
        <br>
        <b>Emissão:</b> {{ $data_documento }}
    </div>
    <div id="alunos" class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">
            <div class="col-sm-12">
                <table id="alunos_table" class="table table-bordered table-hover table-condensed" role="grid">
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
                            <th class="text-center">Local Nascimento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alunos as $aluno)
                        <tr role="row">
                            <td class="text-center">{{ $aluno->codpes }}</td>
                            @php ($nome = \ForceUTF8\Encoding::fixUTF8($aluno->nompes))
                            <td>{{ mb_strtoupper($nome) }}</td>
                            @php ($nommae = \ForceUTF8\Encoding::fixUTF8($aluno->nommaepes))
                            <!-- Ciências Contábeis mostra filiação completa -->
                            @if ($alunos_curso_habil[$aluno->codpes]['codcur'] == '81200')
                            @php ($nompai = \ForceUTF8\Encoding::fixUTF8($aluno->nompaipes))
                            <td>{{ "{$nommae} e {$nompai}" }}</td>
                            @else
                            <td>{{ $nommae }}</td>
                            @endif
                            <td class="text-center">{{ $aluno->dtanas }}</td>
                            <td class="text-center">{{ $aluno->tipdocidf }}</td>
                            <td class="text-center">{{ "{$aluno->numdocfmt}/{$aluno->sglorgexdidf}-{$aluno->estado_rg}" }}</td>
                            <td class="text-center">{{ $aluno->dtaexdidf }}</td>
                            <td class="text-center">{{ $alunos_curso_habil[$aluno->codpes]['codcur'] }}</td>
                            @php ($cidade = \ForceUTF8\Encoding::fixUTF8($aluno->cidloc))
                            @php ($estado = \ForceUTF8\Encoding::fixUTF8($aluno->nomest))
                            @if ($aluno->codpas == 1)
                            <td>{{ "{$cidade} - {$estado}" }}</td>
                            @else
                            @php ($pais = \ForceUTF8\Encoding::fixUTF8($aluno->nompas))
                            <td>{{ "{$cidade} - {$estado} - {$pais}" }}</td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
