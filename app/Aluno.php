<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PDOException;
use Uspdev\Replicado\Graduacao;

class Aluno extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static function sincronizarDados($nusp)
    {
        // não foi passado nenhum número USP
        if (!$nusp) {
            return false;
        }

        // apenas para testar dados de um aluno
        if ($nusp == "7112881") {
            $nusp = "7982169";
        }

        $dados_curso = Graduacao::curso($nusp, env("REPLICADO_CODUND"));

        // sincronizar dados com a base replicada
        // em Graduacao::curso() são retornados diversos dados referentes ao curso
        $aluno = Aluno::find($nusp);

        if (empty($aluno) || (is_null($aluno)) || (count($aluno) == 0)) {
            $aluno = new Aluno();
        }

        $aluno->id = $dados_curso["codpes"];
        $aluno->codpes = $dados_curso["codpes"];
        $aluno->nompes = $dados_curso["nompes"];
        $aluno->codigo_curso = $dados_curso["codcur"];
        $aluno->codigo_habilitacao = $dados_curso["codhab"];
        $aluno->data_ingresso = $dados_curso["dtainivin"];
        try {
            $aluno->save();
            return true;
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }
}
