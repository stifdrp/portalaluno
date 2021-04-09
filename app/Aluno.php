<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;
use PDOException;
use Uspdev\Replicado\Graduacao;
use Uspdev\Replicado\Pessoa;

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

        // Atualizar apenas se estiver desatualizado
        $aluno = Aluno::find($nusp);
        if (($aluno) && ($aluno->updated_at > (Carbon::now()->subDays(1)))) {
            // caso esteja atualizado, sai da função
            return false;
        }

        // verificar inicialmente se o aluno está ativo
        $aluno_ativo = Graduacao::verifica($nusp, env("REPLICADO_CODUND"));
        if (!$aluno_ativo) {
            return false;
        }

        $dados_curso = Graduacao::curso($nusp, env("REPLICADO_CODUND"));
        // email com stamtr = 'S'
        $email = Pessoa::email($nusp);
        // email com stausp = 'S' ou @usp.br
        $email_usp = Pessoa::emailusp($nusp);
        $telefone = Pessoa::telefones($nusp);

        if (empty($email_usp) || (is_null($email_usp))) {
            $todos_emails = Pessoa::emails($nusp);
            // selecionar algum e-mail que não seja igual o administrativo
            $email_alternativo = array_filter($todos_emails, fn ($email_atual) => $email_atual != $email);
            // primeiro item do array email_alternativo
            $email_usp = current($email_alternativo);
        }

        // sincronizar dados com a base replicada
        // Como o model aluno está configurado com SoftDeletes,
        // foi necessário verificar também se o registro não foi deletado
        // para não retornar erro de cadastrar um aluno já existente
        $aluno = Aluno::withTrashed()->find($nusp);

        if (empty($aluno) || (is_null($aluno))) {
            $aluno = new Aluno();
            $aluno->id = $dados_curso["codpes"];
            $aluno->codpes = $dados_curso["codpes"];
        } else {
            $aluno->restore();
        }

        $aluno->nompes = $dados_curso["nompes"];
        $aluno->codigo_curso = $dados_curso["codcur"];
        $aluno->codigo_habilitacao = $dados_curso["codhab"];
        $aluno->data_ingresso = $dados_curso["dtainivin"];
        $aluno->email_administrativo = $email;
        $aluno->email_alternativo = $email_usp;
        $aluno->telefone = $telefone[0];
        try {
            $aluno->save();
            return true;
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    /** 
     * @param string número_usp
     * @return Aluno
     */
    public static function getAluno($nusp)
    {
        if ($nusp) {
            Aluno::sincronizarDados($nusp);
            return Aluno::find($nusp);
        }
    }
}
